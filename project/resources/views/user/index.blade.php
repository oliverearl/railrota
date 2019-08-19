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
                    <th>Home Telephone</th>
                    <th>Work Telephone</th>
                    <th>Mobile Telephone</th>
                    <th>Currently Available</th>
                    <th>Date of Last Inspection</th>
                    <th>Registered On</th>
                    <th>Last Updated On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                <td><a class="btn btn-primary" href="/users/{{$user->id}}">View</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_home }}</td>
                    <td>{{ $user->phone_work }}</td>
                    <td>{{ $user->phone_mobile }}</td>
                    <td>{{ $user->is_available ? 'Yes' : 'No' }}</td>
                    @if (empty($user->date_of_last_inspection))
                        <td><em>Unknown</em></td>
                    @else
                        <td>{{ $user->date_of_last_inspection->format('M d Y') }}</td>
                    @endif
                    @if (empty($user->created_on))
                        <td><em>Unknown</em></td>
                    @else
                        <td>{{ $user->created_on->format('M d Y') }}</td>
                    @endif
                    @if (empty($user->updated_on))
                        <td><em>Unknown</em></td>
                    @else
                        <td>{{ $user->updated_on->format('M d Y') }}</td>
                    @endif
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
