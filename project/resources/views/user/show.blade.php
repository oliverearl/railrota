@extends('layouts.app')

@php
    $title = "Viewing {$user->name}'s Record" ?: 'Viewing Record';
@endphp

@section('title', $title)

@section('content')
    <main class="container">
        <div class="row">
            <div class="col-md-5">
                <h2> Viewing {{ $user->name }}'s Record</h2>
            </div>
            <div class="col-md-7 page-action text-right">
                {{-- Buttons go here --}}
                @if (Auth::id() === $user->id || Auth::user()->is_admin === 1)
                    {{-- Edit --}}
                    <a class="btn btn-outline-primary" href=" {{route('users.edit', $user->id)}}">Edit</a>
                @endif
                <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Back</a>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-12">
                <table class="table table-bordered table-striped table-hover" id="data-table">
                    <thead>
                    <tr>
                        <th>Keys</th>
                        <th>Values</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>First Name</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Surname</td>
                        <td>{{ $user->surname }}</td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    </tr>
                    <tr>
                        <td>Home Telephone</td>
                        <td><a href="tel:{{ $user->phone_home }}">{{ $user->phone_home }}</a></td>
                    </tr>
                    <tr>
                        <td>Work Telephone</td>
                        <td><a href="tel:{{ $user->phone_work }}">{{ $user->phone_work }}</a></td>
                    </tr>
                    <tr>
                        <td>Mobile Telephone</td>
                        <td><a href="tel:{{ $user->phone_mobile }}">{{ $user->phone_mobile }}</a></td>
                    </tr>
                    <tr>
                        <td>Date of Last Inspection</td>
                        @if (is_null($user->date_of_last_inspection))
                            <td class="text-danger">None Recorded</td>
                        @else
                            <td>{{ $user->date_of_last_inspection->format('d/m/Y') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Date of Registration</td>
                        @if (is_null($user->created_at))
                            <td><em>Unknown</em></td>
                        @else
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </section>
        </div>

        <div class="row">
            <section class="col-lg-9">
                <h3>Notes</h3>
                <p>{{ $user->notes }}</p>
            </section>
            <section class="col-lg-3">
                <h3>Roles Qualified</h3>
                @if ($user->roles->isEmpty())
                    <p>{{ $user->name }} does not have any roles.</p>
                @else
                <ul>
                    @foreach ($user->roles as $role)
                        <li><a href="{{ route('role_types.show', $role->role_type->id) }}">{{ $role->role_type->name }}</a></li>
                    @endforeach
                </ul>
                @endif


            </section>
        </div>
    </main>
@endsection
