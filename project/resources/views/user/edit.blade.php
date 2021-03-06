@extends('layouts._control')

@php
    $title = "Editing {$user->name}'s Record" ?: 'Editing Record';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="form-group">
                @method('patch')
                @include('user._form')
            </form>
        </section>
        <section class="col-lg-6">
            @if (Auth::user()->isAdmin())
                <form action="{{ route('roles.store') }}" method="POST" class="form-group">
                    @csrf()
                    <h3>Assign a new role</h3>
                    <div class="form-group @if ($errors->has('role_types')) has-error @endif">
                        <label for="role_types">Role types</label>
                        <select name="role_types" id="role_types" class="form-control">
                            {{-- TODO: I really don't like this. Refactor when you have a better way. --}}
                            {{-- TODO: Update from 27/8/19 - I know how to fix this now, but it'll have to wait --}}
                            @foreach (App\RoleType::all() as $type)
                                <option value="{{$type->id}}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                    <button type="submit" class="form-group btn btn-primary"><i class="fas fa-plus-square"></i> Assign Role</button>
                    <a class="form-group btn btn-secondary" href="{{ route('role_types.create') }}"><i class="fas fa-plus-square"></i> Add New Role Type</a>
                </form>

                <h3>Modify an existing role</h3>
                @if (!$user->roles->isEmpty())
                <table class="table table-responsive table-striped">
                    @foreach ($user->roles as $role)
                        <thead>
                        <tr>
                            <th>Role</th>
                            <th>Competency</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tr>
                            <td><a href="{{ route('role_types.show', $role->role_type->id) }}">{{ $role->role_type->name }}</a></td>
                            @if (!is_null($role->role_competency))
                                <td><a href="{{ route('role_competencies.show', $role->role_competency->id) }}">{{ $role->role_competency->name }}</a></td>
                            @else
                                <td><em>No Competency Assigned</em></td>
                            @endif
                            <td><a class="form-group btn btn-primary" href="{{ route('roles.edit', $role->id) }}"><i class="fas fa-edit"></i> Edit</a></td>
                            <td>
                                <form id="delete_role_{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                    @csrf()
                                    @method('delete')
                                    <input name="id" id="role_{{ $role->id }}" type="hidden" value="{{$role->id}}">
                                    <button class="form-group btn btn-danger" type="submit"><i class="far fa-trash-alt"></i> Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                <p>{{$user->name}} does not have any roles.</p>
                @endif
            @else
                @include('user._roles')
            @endif
        </section>
    </div>
@endsection
