<?php

namespace App\Http\Controllers;

use App\RoleType;
use Illuminate\Http\Request;

class RoleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleTypes = RoleType::latest()->paginate();
        return view('role_type.index', compact('roleTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoleType  $roleType
     * @return \Illuminate\Http\Response
     */
    public function show(RoleType $roleType)
    {
        return view('role_type.show', compact('roleType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoleType  $roleType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoleType $roleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoleType  $roleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleType $roleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoleType  $roleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleType $roleType)
    {
        //
    }
}
