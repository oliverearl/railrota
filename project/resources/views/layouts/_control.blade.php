@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <h2>@yield('subtitle')</h2>
        </div>
        <div class="col-md-7 page-action text-right">
            @yield('buttons')
        </div>
    </div>
    @include('layouts._errors')
    @yield('route')
@endsection
