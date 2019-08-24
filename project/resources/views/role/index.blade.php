@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="container">
        <div class="result-set">
                @if ($roles->isEmpty())
                    <p>No roles are present.</p>
                @else
                    <table class="table table-bordered table-striped table-hover" id="data-table">
                        <thead>
                        <tr>
                            @if (Auth::user()->isAdmin())
                                <th>Edit</th>
                                <th>Delete</th>
                            @endif
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Role Type</th>
                            <th>Competency Level</th>
                            <th>Role Since</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                @if (Auth::user()->isAdmin())
                                    <td><a class="btn btn-primary" href=" {{ route('roles.edit', $role->id) }}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                                            @csrf()
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                @endif
                                <td>{{ $role->user->name }}</td>
                                <td>{{ $role->user->surname }}</td>
                                <td>{{ $role->role_type->name }}</td>
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
