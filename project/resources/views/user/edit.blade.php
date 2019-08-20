@extends('user._user')

@php
    $title = "Editing {$user->name}'s Record" ?: 'Editing Record';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="form-group">
                @method('patch')
                @include('user._form')
            </form>
        </section>
        <section class="col-lg-6">
            @if (Auth::user()->is_admin)

            @else
                @include('user._roles')
            @endif
        </section>
    </div>
@endsection
