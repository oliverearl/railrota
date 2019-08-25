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
        return view('role_type.create');
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
            'name' => 'required|min:1|max:255|string|unique:role_types,name',
            'description' => 'min:1|max:1024}string|nullable',
        ]);

        $roleType = new RoleType();
        $roleType->fill($request->all());
        $roleType->save();

        flash()->success("{$roleType->name} has been added successfully!")->important();
        return redirect()->route('role_types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoleType  $roleType
     * @return \Illuminate\Http\Response
     */
    public function show(RoleType $roleType)
    {
        $competencies = $roleType->role_competencies()->get();

        return view('role_type.show', compact('roleType', 'competencies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\RoleType $roleType
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(RoleType $roleType)
    {
        $this->authorize('manipulate');

        return view('role_type.edit', compact('roleType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\RoleType $roleType
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, RoleType $roleType)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string|unique:role_types,name,' . $roleType->id,
            'description' => 'min:1|max:1024}string|nullable',
        ]);

        $roleType->fill($request->all());
        $roleType->save();

        flash()->success("{$roleType->name} has been updated successfully!")->important();
        return redirect()->route('role_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\RoleType $roleType
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(RoleType $roleType)
    {
        $this->authorize('manipulate');

        $roleType->delete();

        flash()->success("Role Type deleted successfully!")->important();

        return redirect()->route('role_types.index');
    }
}
