<?php

namespace App\Http\Controllers;

use App\PoweredLocomotive;
use Illuminate\Http\Request;

class PoweredLocomotiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poweredLocomotives = PoweredLocomotive::latest()->paginate();
        return view('powered_locomotive.index', compact('poweredLocomotives'));
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

        return view ('powered_locomotive.create');
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
            'name' => 'required|min:1|max:255|string|unique:powered_locomotives,name',
            'description' => 'min:1|max:1024|string|nullable',
        ]);

        $poweredLocomotive = new PoweredLocomotive();
        $poweredLocomotive->fill($request->all());
        $poweredLocomotive->save();

        flash()->success("{$poweredLocomotive->name} has been added successfully!")->important();
        return redirect()->route('powered_locomotives.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PoweredLocomotive  $poweredLocomotive
     * @return \Illuminate\Http\Response
     */
    public function show(PoweredLocomotive $poweredLocomotive)
    {
        return view ('powered_locomotive.show', compact('poweredLocomotive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\PoweredLocomotive $poweredLocomotive
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(PoweredLocomotive $poweredLocomotive)
    {
        $this->authorize('manipulate');

        return view ('powered_locomotive.edit', compact('poweredLocomotive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PoweredLocomotive $poweredLocomotive
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, PoweredLocomotive $poweredLocomotive)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string|unique:powered_locomotives,name,' . $poweredLocomotive->id,
            'description' => 'min:1|max:1024|string|nullable',
        ]);

        $poweredLocomotive->fill($request->all());
        $poweredLocomotive->save();

        flash()->success("{$poweredLocomotive->name} has been updated successfully!")->important();
        return redirect()->route('powered_locomotives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PoweredLocomotive $poweredLocomotive
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(PoweredLocomotive $poweredLocomotive)
    {
        $this->authorize('manipulate');

        $poweredLocomotive->delete();

        flash()->success("Locomotive deleted successfully!")->important();

        return redirect()->route('powered_locomotives.index');
    }
}
