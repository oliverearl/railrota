@extends('layouts.app')

@php
    $title = "Viewing {$user->name}'s Record" ?: 'Viewing Record';
@endphp

@section('title', $title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <h3>Viewing {{ $user->name }}'s Record</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ route('users.index') }}" class="btn btn-default btn-sm">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('user._form')
        </div>
    </div>
@endsection
