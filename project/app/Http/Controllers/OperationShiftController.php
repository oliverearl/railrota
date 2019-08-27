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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Operation $operation
     * @return void
     */
    public function create(Operation $operation)
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Operation $operation
     * @param \App\OperationShift $operationShift
     * @return void
     */
    public function edit(Operation $operation, OperationShift $operationShift)
    {
        //
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
     */
    public function destroy(Operation $operation, OperationShift $operationShift)
    {
        //
    }
}
