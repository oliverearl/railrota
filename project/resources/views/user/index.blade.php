@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container">
    <div class="result-set">
        <table class="table table-bordered table-striped table-hover" id="data-table">
            <thead>
                <tr>
                    <th></th>
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
                <td><a class="btn btn-primary" href="/users/{{$user->id}}">View</td>
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
    </div>
</div>
@endsection
