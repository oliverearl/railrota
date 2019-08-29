@extends('layouts._table')

@php
    $title = "Viewing {$role->user->name}'s {$role->role_type->name} Role" ?: 'Viewing Role';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href=" {{route('roles.edit', $role->id)}}"><i class="fas fa-edit"></i> Edit</a>
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
            @csrf()
            @method('delete')
            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('roles.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('table_content')
    <thead>
    <tr>
        <th>Keys</th>
        <th>Values</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Full Name</td>
        <td>{{ $role->user->name }} {{ $role->user->surname }}</td>
    </tr>
    <tr>
        <td>Email Address</td>
        <td><a href="mailto: {{ $role->user->email }}">{{ $role->user->email }}</a></td>
    </tr>
    <tr>
        <td>Role Type</td>
        <td><a href="{{ route('role_types.show', $role->role_type_id) }}">{{ $role->role_type->name }}</a></td>
    </tr>
    <td>Role Grade / Competency</td>
    @if (is_null($role->role_competency))
        <td><em>None Assigned</em></td>
    @else
        <td><a href="{{ route('role_competencies.show', $role->role_competency_id) }}">{{ $role->role_competency->name }}</a></td>
    @endif
    <tr>
        <td>Role since:</td>
        @if (is_null($role->created_at))
            <td><em>Unknown</em></td>
        @else
            <td>{{ $role->created_at->format('d/m/Y') }}</td>
        @endif
    </tr>
    </tbody>
@endsection
