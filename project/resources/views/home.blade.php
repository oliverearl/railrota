@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ config('app.name') }}</div>
                <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid img-thumbnail rounded mx-auto d-block" src="{{ @asset('images/logo.png') }}" alt="Logo">
                            <p>Welcome to Railrota!</p>
                            @if (config('app.env') === 'local')
                                <p><strong>I am running in development mode!</strong></p>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
