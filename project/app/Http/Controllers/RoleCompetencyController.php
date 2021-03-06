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
        $roleCompetencies = RoleCompetency::orderBy('name', 'asc')->paginate();
        return view('role_competency.index', compact('roleCompetencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('manipulate');

        $roleTypes = RoleType::all();

        return view ('role_competency.create', compact('roleTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string',
            'description' => 'min:1|max:1024|string|nullable',
            'tier' => 'required|min:1|max:10|integer|numeric',
            'role_type_id' => 'required|integer|exists:role_types,id'
        ]);

        $roleCompetency = new RoleCompetency();
        $roleCompetency->fill($request->all());
        $roleCompetency->save();

        flash()->success("{$roleCompetency->name} has been added successfully!")->important();
        return redirect()->route('role_competencies.index');
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
     * @param \App\RoleCompetency $roleCompetency
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(RoleCompetency $roleCompetency)
    {
        $this->authorize('manipulate');

        $roleTypes = RoleType::all();

        return view('role_competency.edit', compact('roleCompetency', 'roleTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\RoleCompetency $roleCompetency
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, RoleCompetency $roleCompetency)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string',
            'description' => 'min:1|max:1024|string|nullable',
            'tier' => 'required|min:1|max:10|integer|numeric',
            'role_type_id' => 'required|integer|exists:role_types,id'
        ]);

        $roleCompetency->fill($request->all());
        $roleCompetency->save();

        flash()->success("{$roleCompetency->name} has been updated successfully!")->important();
        return redirect()->route('role_competencies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\RoleCompetency $roleCompetency
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(RoleCompetency $roleCompetency)
    {
        $this->authorize('manipulate');

        $roleCompetency->delete();

        flash()->success('Role Competency deleted successfully!')->important();

        return redirect()->route('role_competencies.index');
    }
}
