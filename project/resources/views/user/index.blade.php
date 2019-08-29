@extends('layouts.app')

@php
    $title = 'Users';
@endphp
@section('title', $title)

@section('content')
    <div class="container">
        <div class="result-set">
            <h1> {{ $title }}</h1>
            @if ($users->isEmpty())
                <p>No users are present.</p>
            @else
                <table class="table table-bordered table-striped table-hover" id="data-table">
                    <thead>
                    <tr>
                        <th>View</th>
                        @if(Auth::user()->isAdmin())
                            <th>Edit</th>
                            <th>Delete</th>
                        @endif
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email Address</th>
                        <th>Roles</th>
                        <th>Home Telephone</th>
                        <th>Work Telephone</th>
                        <th>Mobile Telephone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><a class="btn btn-secondary" href="{{ route('users.show', $user->id) }}"><i class="fas fa-binoculars"></i> View</a></td>
                            @if (Auth::user()->isAdmin())
                                <td><a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i> Edit</a></td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                        @csrf()
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->roles->isEmpty())
                                <td><em>No Roles Allocated</em></td>
                            @else
                                <td>
                                    @foreach ($user->roles as $role)
                                        <a href="{{ route('role_types.show', $role->role_type->id) }}">{{ $role->role_type->name }}</a><br>
                                    @endforeach
                                </td>
                            @endif
                            <td>{{ $user->phone_home }}</td>
                            <td>{{ $user->phone_work }}</td>
                            <td>{{ $user->phone_mobile }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
        @if (Auth::user()->isAdmin())
            <div class="col-md-12 page-action">
                <a class="btn btn-primary" href="{{ route('users.create') }}"><i class="fas fa-plus-square"></i> Add User</a>
            </div>
        @endif
    </div>
@endsection
