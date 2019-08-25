<?php

namespace App\Http\Controllers;

use App\RoleCompetency;
use App\RoleType;
use Illuminate\Http\Request;

class RoleCompetencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleCompetencies = RoleCompetency::latest()->paginate();
        return view('role_competency.index', compact('roleCompetencies'));
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
     * @param  \App\RoleCompetency  $roleCompetency
     * @return \Illuminate\Http\Response
     */
    public function show(RoleCompetency $roleCompetency)
    {
        return view ('role_competency.show', compact('roleCompetency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoleCompetency  $roleCompetency
     * @return \Illuminate\Http\Response
     */
    public function edit(RoleCompetency $roleCompetency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoleCompetency  $roleCompetency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleCompetency $roleCompetency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoleCompetency  $roleCompetency
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleCompetency $roleCompetency)
    {
        //
    }
}
