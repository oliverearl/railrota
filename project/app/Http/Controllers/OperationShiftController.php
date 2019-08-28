<?php

namespace App\Http\Controllers;

use App\Operation;
use App\OperationShift;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperationShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Operation $operation
     * @return void
     */
    public function index(Operation $operation)
    {
        return redirect()->route('operations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Operation $operation
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Operation $operation)
    {
        $this->authorize('create');
        $data = OperationShift::getData();

        return view('shift.create', compact('operation', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Operation $operation
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Operation $operation, Request $request)
    {
        $this->authorize('store');

        $this->validate($request, [
            'role_type_id' => 'required|integer|exists:role_types,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'location_id' => 'nullable|integer|exists:locations,id',
            'powered_locomotive_id' => 'nullable|integer|exists:powered_locomotives,id',
            'steam_locomotive_id' => 'nullable|integer|exists:steam_locomotives,id',
            'notes' => 'min:1|max:1024|string|nullable',
        ]);

        $operationShift = new OperationShift();
        $operationShift->fill($request->all());
        $operationShift->operation_id = $operation->id;
        $operationShift->save();

        flash()->success("{$operationShift->role_type->name} shift has been updated successfully!")->important();
        return redirect()->route('operations.show', $operation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Operation $operation
     * @param \App\OperationShift $operationShift
     * @return void
     */
    public function show(Operation $operation, OperationShift $operationShift)
    {
        return redirect()->route('operations.show', $operation->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Operation $operation
     * @param $id
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Operation $operation, $id)
    {
        // TODO: I can't get the model binding to work right now, so I know something with my Eloquent models is janky
        // This will do in the meanwhile.

        $this->authorize('edit');
        $operationShift = OperationShift::findOrFail($id);
        $data = OperationShift::getData();

        return view('shift.edit', compact('operation', 'operationShift', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Operation $operation
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Operation $operation, Request $request, $id)
    {
        // TODO: I really need to take this shift class back to the drawing board

        $this->authorize('update');

        $this->validate($request, [
            'role_type_id' => 'required|integer|exists:role_types,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'location_id' => 'nullable|integer|exists:locations,id',
            'powered_locomotive_id' => 'nullable|integer|exists:powered_locomotives,id',
            'steam_locomotive_id' => 'nullable|integer|exists:steam_locomotives,id',
            'notes' => 'min:1|max:1024|string|nullable',
        ]);

        $operationShift = OperationShift::findOrFail($id);

        // TODO: Kinda hacky but stops competencies persisting to the wrong role types
        if (!is_null($operationShift->role_competency_id)) {
            if ($operationShift->role_competency->role_type->id !== $request->role_type_id) {
                $operationShift->role_competency_id = null;
            }
        }

        $operationShift->fill($request->all());
        $operationShift->save();

        flash()->success("{$operationShift->role_type->name} shift has been updated successfully!")->important();
        return redirect()->route('operations.show', $operation->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Operation $operation
     * @param \App\OperationShift $operationShift
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Operation $operation, $id)
    {
        $this->authorize('destroy');
        $operationShift = OperationShift::findOrFail($id);
        $operationShift->delete();

        flash()->success('Shift deleted successfully!')->important();

        return redirect()->route('operations.show', $operation->id);
    }
}
