<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Figure out some form of damn pagination when using joins
        //$roles = Role::join('users', 'roles.user_id', '=', 'users.id')->orderBy('users.name', 'asc')->get();
        $roles = Role::latest()->paginate();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        flash()->warning('Roles cannot be made directly.')->important();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id',
            'role_types' => 'required|integer|exists:role_types,id'
        ]);

        $query = Role::where([
            ['user_id', '=', $request->user_id],
            ['role_type_id', '=', $request->role_types],
        ])->get();

        if (!$query->isEmpty()) {
            flash()->error('That role already exists.')->important();
            return redirect()->back();
        }

        $role = Role::create([
            'user_id' => $request->user_id,
            'role_type_id' => $request->role_types,
        ]);

        flash()->success('Role added successfully!')->important();
        return redirect()->route('roles.edit', $role->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('manipulate');

        $competencies = $role->role_type->role_competencies()->get();

        return view('role.edit', compact('role', 'competencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'role_type_id' => 'required|integer|exists:role_competencies,role_type_id',
            'role_competency_id' => 'required|integer|exists:role_competencies,id',
        ]);

        $role->fill($request->only('role_competency_id'));
        $role->save();

        flash()->success('Role modified successfully!')->important();
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Role $role)
    {
        $this->authorize('manipulate');

        $role->delete();

        flash()->success("Role deleted successfully!")->important();

        return redirect()->route('roles.index');
    }
}
