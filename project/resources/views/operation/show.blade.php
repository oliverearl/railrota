@extends('layouts._control')

@php
    $title = 'Viewing Operation';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('operations.index') }}">Back</a>
@endsection

@section('route')
    <div class="container-fluid">
        @include('operation._operation')
    </div>
@endsection
