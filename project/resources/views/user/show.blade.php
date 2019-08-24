@extends('layouts._control')

@php
    $title = "Viewing {$user->name}'s Record" ?: 'Viewing Record';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
{{-- Buttons go here --}}
@if (Auth::id() === $user->id || Auth::user()->isAdmin())
    {{-- Edit --}}
    <a class="btn btn-outline-primary" href=" {{route('users.edit', $user->id)}}">Edit</a>
@endif
<a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Back</a>
@endsection

@section('route')
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
        @include('user._roles')
    </section>
</div>
@endsection
