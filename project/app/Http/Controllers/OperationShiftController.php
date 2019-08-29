<?php

namespace App\Http\Controllers;

use App\Operation;
use App\OperationShift;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return redirect()->route('operations.shifts.competency', [$operation->id, $operationShift->id]);
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

            'role_competency_id' => 'nullable|integer|exists:role_competencies,id',
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
        //return redirect()->route('operations.show', $operation->id);
        return redirect()->route('operations.shifts.competency', [$operation->id, $operationShift->id]);
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

    public function register(Operation $operation, $id)
    {
        // $this->authorize('register'); // currently not using in exchange for this absolute unit

        $operationShift = OperationShift::findOrFail($id);

        // ADMIN IS CRUISE CONTROL FOR COOL
        if (!Auth::user()->isAdmin()) {
            // Check role
            $roleCheck = Role::where([
                ['user_id', '=', Auth::id()],
                ['role_type_id', '=', $operationShift->role_type_id]
            ])->first();
            //dd($roleCheck);
            if (is_null($roleCheck)) {
                flash()->error('You do not have the required role type.')->important();
                return redirect()->back();
            } else {
                // Check if it has a competency level
                if (!is_null($operationShift->role_competency_id)) {
                    if ($roleCheck->role_competency->tier < $operationShift->role_competency->tier) {
                        flash()->error('You do not have a sufficient competency / grade tier.')->important();
                        return redirect()->back();
                    }
                }
                // Regardless of whether the requirement is null, or the tier requirement is met
                // Check for vacancy - you shouldn't be able to register anyway, but it's for protection in any case
                if (!is_null($operationShift->user_id) && $operationShift->user_id !== Auth::id()) {
                    flash()->error('This shift is not vacant.')->important();
                    return redirect()->back();
                }
            }
        }

        // Assuming everything was a tremendous success at this point
        $operationShift->user_id = Auth::id();
        $operationShift->update();

        flash()->success('You have successfully volunteered for this shift.');
        return redirect()->route('operations.show', $operation->id);
    }

    public function deregister(Operation $operation, $id)
    {
        $operationShift = OperationShift::findOrFail($id);

        abort_unless($operationShift->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        $operationShift->user_id = null;
        $operationShift->update();

        flash()->success('You have pulled out of this shift.');
        return redirect()->route('operations.show', $operation->id);
    }

    public function competency(Operation $operation, $id)
    {
        $this->authorize('edit');
        $operationShift = OperationShift::findOrFail($id);

        return view('shift.competency', compact('operation', 'operationShift'));
    }
}
