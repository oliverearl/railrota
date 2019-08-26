<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::latest()->paginate();
        return view('location.index', compact('locations'));
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

        return view ('location.create');
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
            'name' => 'required|min:1|max:255|string|unique:locations,name',
            'description' => 'min:1|max:1024|string|nullable',
        ]);

        $location = new Location();
        $location->fill($request->all());
        $location->save();

        flash()->success("{$location->name} has been added successfully!")->important();
        return redirect()->route('locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view ('location.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Location $location
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Location $location)
    {
        $this->authorize('manipulate');

        return view ('location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $this->authorize('manipulate');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string|unique:locations,name,' . $location->id,
            'description' => 'min:1|max:1024|string|nullable',
        ]);

        $location->fill($request->all());
        $location->save();

        flash()->success("{$location->name} has been updated successfully!")->important();
        return redirect()->route('locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Location $location
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Location $location)
    {
        $this->authorize('manipulate');

        $location->delete();

        flash()->success("Location deleted successfully!")->important();

        return redirect()->route('locations.index');
    }
}
