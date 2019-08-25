@extends('layouts._control')

@php
    $title = "Editing {$roleType->name} Role Type" ?: 'Editing Role Type';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('role_types.index') }}">Back</a>
@endsection

@section('route')
    @include('role_type._form')
@endsection
