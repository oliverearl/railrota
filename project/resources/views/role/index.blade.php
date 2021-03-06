@extends('layouts.app')

@php
    $title = 'Roles';
@endphp
@section('title', $title)

@section('content')
    <div class="container">
        <div class="result-set">
            <h1>{{ $title }}</h1>
                @if ($roles->isEmpty())
                    <p>No roles are present.</p>
                @else
                    <table class="table table-bordered table-striped table-hover" id="data-table">
                        <thead>
                        <tr>
                            <th>View</th>
                            @if (Auth::user()->isAdmin())
                                <th>Edit</th>
                                <th>Delete</th>
                            @endif
                            <th>Full Name</th>
                            <th>Role Type</th>
                            <th>Competency Level</th>
                            <th>Role Since</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td><a class="btn btn-secondary" href="{{ route('roles.show', $role->id) }}"><i class="fas fa-binoculars"></i> View</a></td>
                                @if (Auth::user()->isAdmin())
                                    <td><a class="btn btn-primary" href=" {{ route('roles.edit', $role->id) }}"><i class="fas fa-edit"></i> Edit</a></td>
                                    <td>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                                            @csrf()
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
                                        </form>
                                    </td>
                                @endif
                                <td><a href="{{ route('users.show', $role->user->id) }}">{{ $role->user->name }} {{ $role->user->surname }}</a></td>
                                <td><a href="{{ route('role_types.show', $role->role_type->id) }}">{{ $role->role_type->name }}</a></td>
                                @if (is_null($role->role_competency))
                                    <td><em>No Competency Assigned</em></td>
                                @else
                                    <td>{{ $role->role_competency->name }}</td>
                                @endif
                                @if (is_null($role->created_at))
                                    <td><em>Unknown</em></td>
                                @else
                                    <td>{{ $role->created_at->format('d/m/Y') }}</td>
                                @endif
                            </tr>
                        @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection
