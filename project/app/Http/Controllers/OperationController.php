<?php

namespace App\Http\Controllers;

use App\Operation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operations = Operation::orderBy('date', 'desc')->paginate(3);
        return view('operation.index', compact('operations'));
    }

    public function glance()
    {
        $operations = Operation::orderBy('date', 'desc')->paginate();
        return view('operation.glance', compact('operations'));
    }

    public function pdf()
    {
        // TODO: Complete PDF functionality
        // This is just a template for now, but will be filled out later

        // $filename = Carbon::now()->format('ymd') . '_operations.pdf'

        // $operations = Operations::get();
        // $pdf = PDF::loadView('operation.pdf', $operations);
        // $pdf->save(storage_path() . $filename);
        // return $pdf->download($filename);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create');

        return view('operation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->authorize('store');

        $this->validate($request, [
            'date' => 'date|required|unique:operations,date',
            'notes' => 'min:1|max:1024|string|nullable'
        ]);

        $operation = new Operation();
        $operation->fill($request->all());
        $operation->save();

        flash()->success("A new operation has been added successfully!")->important();
        return redirect()->route('operations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function show(Operation $operation)
    {
        return view('operation.show', compact('operation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Operation $operation
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Operation $operation)
    {
        $this->authorize('edit');

        return view('operation.edit', compact('operation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Operation $operation
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Operation $operation)
    {
        $this->authorize('update');

        $this->validate($request, [
            'date' => 'date|required|unique:operations,date,' . $operation->id,
            'notes' => 'min:1|max:1024|string|nullable',
            'is_running' => 'boolean',
        ]);

        $operation->fill($request->all());

        // Same boolean check for UserController.
        // TODO: This garbage really can't stay
        if (is_null($request->get('is_running'))) {
            $operation->is_running = 0;
        } else {
            $operation->is_running = 1;
        }

        $operation->save();

        $date = Carbon::parse($operation->date)->format('d-m-y');
        flash()->success("Operation {$date} has been updated successfully!")->important();
        return redirect()->route('operations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation)
    {
        //
    }
}
