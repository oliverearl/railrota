@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <div class="row">
            <div class="col-6 col-md">
                <h2>{{ config('app.name') }}</h2>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="{{ route('home') }}">Homepage</a></li>
                    <li><a class="text-muted" href="https://github.com/oliverearl/railrota" target="_blank">GitHub Repository</a></li>
                    <li><a class="text-muted" href="mailto:ole4@aber.ac.uk">Contact Developer</a></li>
                    <li><a class="text-muted" href="{{ route('telescope') }}" target="_blank">Launch Laravel Telescope</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h2>Users and Roles</h2>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="{{ route('users.create') }}">Create User</a></li>
                    <li><a class="text-muted" href="{{ route('users.edit', Auth::user()) }}">Edit Current User</a></li>
                    <li><a class="text-muted" href="{{ route('users.index') }}">View Users</a></li>
                    <li><a class="text-muted" href="{{ route('roles.index') }}">View Roles</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h2>Types and Competencies</h2>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="{{ route('role_types.create') }}">Create Role Type</a></li>
                    <li><a class="text-muted" href="{{ route('role_types.index') }}">View Role Types</a></li>
                    <li><a class="text-muted" href="{{ route('role_competencies.create') }}">Create Role Competency</a></li>
                    <li><a class="text-muted" href="{{ route('role_competencies.index') }}">View Role Competencies</a></li>
                </ul>
            </div>
        </div>

    <div class="row">
        <div class="col-6 col-md">
            <h2>Vehicles</h2>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="{{ route('powered_locomotives.index') }}">View Diesel or Electric Locomotives</a></li>
                <li><a class="text-muted" href="{{ route('powered_locomotives.create') }}">Add a Diesel or Electric Locomotive</a></li>
                <li><a class="text-muted" href="{{ route('steam_locomotives.index') }}">View Steam Locomotives</a></li>
                <li><a class="text-muted" href="{{ route('steam_locomotives.create') }}">Add a Steam Locomotive</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h2>Locations</h2>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="{{ route('locations.index') }}">View Locations</a></li>
                <li><a class="text-muted" href="{{ route('locations.create') }}">Add a Location</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h2>Operations</h2>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="{{ route('operations.index') }}">View Operations</a></li>
                <li><a class="text-muted" href="{{ route('operations.create') }}">Add an Operation</a></li>
                <li><a class="text-muted" href="{{ route('operations.glance') }}">Glance View</a></li>
                <li><a class="text-muted" href="{{ route('operations.pdf') }}">Export PDF</a></li>
            </ul>
        </div>
    </div>
@endsection
