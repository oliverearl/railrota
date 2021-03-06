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
        $users = User::orderBy('name', 'asc')->paginate();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create');

        return view('user.create');
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
        $this->authorize('create');

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string',
            'surname' => 'min:1|max:255|string|nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:1|max:255|string|confirmed'
        ]);
        $user = new User();
        $user->fill($request->except('password', 'is_available', 'is_admin'));
        $user->password = bcrypt($request->password);
        $user->save();

        flash()->success("{$user->name} has been added successfully!")->important();
        return redirect()->route('users.edit', $user->id);
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
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'required|min:1|max:255|string',
            'surname' => 'min:1|max:255|string|nullable',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_home' => 'min:1|max:15|nullable|',
            'phone_work' => 'min:1|max:24|nullable',
            'phone_mobile' => 'min:1|max:15|nullable',
            'date_of_last_inspection' => 'date|nullable',
            'is_available' => 'boolean',
            'is_admin' => 'boolean',
            'notes' => 'min:1:max1024|string|nullable',
        ]);

        $user->fill($request->except('password', 'is_available', 'is_admin', 'date_of_last_inspection'));

        // Check if admin-only things have been filled in and validate accordingly
        if (($request->get('is_admin') || $request->get('date_of_last_inspection'))) {
            abort_unless(Auth::user()->isAdmin(), 403, 'You are not authorised to do that.');
        }

        // Check for password changes
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Date of last inspection
        if ($request->get('date_of_last_inspection')) {
            $user->date_of_last_inspection = $request->get('date_of_last_inspection');
        }

        // TODO: Figure out a much better way to handle checkboxes because this is disgusting. Really disgusting.
        // Check for change in availability by means of its absence
        if (is_null($request->get('is_available'))) {
            $user->is_available = 0;
        } else {
            $user->is_available = 1;
        }

        // Do the same for admins
        if ($request->get('is_admin')) {
            $user->is_admin = 1;
        } else {
            $user->is_admin = 0;
        }

        $user->save();

        flash()->success("{$user->name} has been updated successfully!")->important();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === Auth::id()) {
            flash()->error('You can\'t delete yourself!')->important();
            return redirect()->back();
        }

        $user->delete();
        flash()->success("{$user->name} has been deleted successfully!")->important();
        return redirect()->route('users.index');
    }
}
