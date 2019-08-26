<?php

namespace App\Http\Controllers;

use App\SteamLocomotive;
use Illuminate\Http\Request;

class SteamLocomotiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $steamLocomotives = SteamLocomotive::latest()->paginate();
        return view('steam_locomotive.index', compact('steamLocomotives'));
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

        return view('steam_locomotive.create');
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
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string|unique:powered_locomotives,name',
            'description' => 'min:1|max:1024|string|nullable',
        ]);

        $steamLocomotive = new SteamLocomotive();
        $steamLocomotive->fill($request->all());
        $steamLocomotive->save();

        flash()->success("{$steamLocomotive->name} has been added successfully!")->important();
        return redirect()->route('steam_locomotives.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SteamLocomotive  $steamLocomotive
     * @return \Illuminate\Http\Response
     */
    public function show(SteamLocomotive $steamLocomotive)
    {
        return view('steam_locomotive.show', compact('steamLocomotive'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\SteamLocomotive $steamLocomotive
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(SteamLocomotive $steamLocomotive)
    {
        $this->authorize('manipulate');

        return view('steam_locomotive.edit', compact('steamLocomotive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SteamLocomotive $steamLocomotive
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, SteamLocomotive $steamLocomotive)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string|unique:steam_locomotives,name,' . $steamLocomotive->id,
            'description' => 'min:1|max:1024|string|nullable',
        ]);

        $steamLocomotive->fill($request->all());
        $steamLocomotive->save();

        flash()->success("{$steamLocomotive->name} has been updated successfully!")->important();
        return redirect()->route('steam_locomotives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SteamLocomotive $steamLocomotive
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(SteamLocomotive $steamLocomotive)
    {
        $this->authorize('manipulate');

        $steamLocomotive->delete();

        flash()->success('Locomotive deleted successfully')->important();

        return redirect()->route('steam_locomotives.index');
    }
}
