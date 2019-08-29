@extends('layouts._control')

@php
    $title = 'Adding a new User';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <form action="{{ route('users.store') }}" method="POST" class="form-group">
                @csrf()
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    <label class="" for="name">First Name</label>
                    <input class="form-control"
                           type="text"
                           name="name"
                           id="name"
                           minlength="1"
                           maxlength="255"
                           required
                           value="{{ old('name') }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('surname')) has-error @endif">
                    <label class="" for="surname">Surname</label>
                    <input class="form-control"
                           type="text"
                           name="surname"
                           id="surname"
                           minlength="1"
                           maxlength="255"
                           value="{{ old('surname') }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('email')) has-error @endif">
                    <label class="" for="email">Email Address</label>
                    <input class="form-control"
                           type="email"
                           name="email"
                           id="email"
                           minlength="1"
                           maxlength="255"
                           required
                           value="{{ old('email') }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    <label class="" for="password">Password</label>
                    <input class="form-control"
                           type="password"
                           name="password"
                           id="password"
                           minlength="1"
                           maxlength="255"
                           required
                    >

                    <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                        <label class="" for="password_confirmation">Confirm Password</label>
                        <input class="form-control"
                               type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               minlength="1"
                               maxlength="255"
                               required
                        >
                    </div>

                    <div class="form-group">
                        <input class="form-group btn btn-primary" type="submit" value="Submit">
                    </div>
                </div>
            </form>
        </section>
    </div>

@endsection

