<?php

namespace App\Http\Controllers;

use App\Operation;
use App\OperationShift;
use Illuminate\Http\Request;

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

        return view('shift.create', compact('operation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Operation $operation
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Operation $operation, Request $request)
    {
        //
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
     * @param \App\OperationShift $operationShift
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Operation $operation, OperationShift $operationShift)
    {
        $this->authorize('edit');

        return view ('shift.edit', compact('operation', 'operationShift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Operation $operation
     * @param \Illuminate\Http\Request $request
     * @param \App\OperationShift $operationShift
     * @return void
     */
    public function update(Operation $operation, Request $request, OperationShift $operationShift)
    {
        //
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
    public function destroy(Operation $operation, OperationShift $operationShift)
    {
        $this->authorize('destroy');

        $operationShift->delete();

        flash()->success('Shift deleted successfully!')->important();

        return redirect()->route('operations.show', $operation->id);
    }
}
