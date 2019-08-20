@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="container">
        <div class="result-set">
            <table class="table table-bordered table-striped table-hover" id="data-table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Role Type</th>
                        <th>Role Since</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->user->name }}</td>
                        <td>{{ $role->user->surname }}</td>
                        <td>{{ $role->role_type->name }}</td>
                        <td>{{ $role->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
