@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ config('app.name') }}</div>
                <div class="card-body">
                    <h2>Welcome!</h2>
                    <p>Railrota requires you to <a href="{{ route('login') }}">login</a>, or <a href="{{ route('register') }}">register</a> a new account.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
