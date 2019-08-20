<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate();

        return view('user.index', compact('users'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:255|string',
            'surname' => 'min:1|max:255|string|nullable',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_home' => 'min:1|max:15|nullable|',
            'phone_work' => 'min:1|max:24|nullable',
            'phone_mobile' => 'min:1|max:15',
            'date_of_last_inspection' => 'date|nullable',
            'is_available' => 'boolean',
            'is_admin' => 'boolean',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->except('password', 'is_available'));

        // Check if admin-only things have been filled in and validate accordingly
        if (($request->get('is_admin') || $request->get('date_of_last_inspection'))) {
            if (Auth::user()->is_admin === 0) {
                flash()->error('You are not authorised to do that.')->important();
                return redirect()->back();
            }
        }

        // Check for password changes
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // TODO: Figure out a much better way to handle checkboxes because this is disgusting. Really disgusting.

        // Check for change in availability by means of its absence
        if (is_null($request->get('is_available'))) {
            $user->is_available = 0;
        } else {
            $user->is_available = 1;
        }

        // Same with admin
        if (is_null($request->get('is_admin'))) {
            $user->is_admin = 0;
        } else {
            $user->is_admin = 1;
        }

        $user->save();

        flash()->success('Update successful!')->important();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Behaviour currently not intended.
        //
    }
}
