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
                            <a href="https://www.github.com/oliverearl/railrota" target="_blank"><img class="img-fluid img-thumbnail rounded mx-auto d-block" src="{{ @asset('images/logo.png') }}" alt="Logo"></a>
                            <p>Welcome to Railrota!</p>
                            @if (config('app.env') === 'local')
                                <p><strong>I am running in development mode!</strong></p>
                            @endif
                        </div>
                    <table class="table-responsive table-striped table">
                        <thead>
                        <tr>
                            <th colspan="2"><em>At a glance...</em></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Your Upcoming Shifts</td>
                            @php
                                $count = 0;
                            @endphp
                            {{-- TODO: Disgusting, yes. I shouldn't do this from a view, but it's a super last minute thing and my patience is wearing thin. --}}
                            @foreach (Auth::user()->operation_shifts()->get() as $shift)
                                @if (\Carbon\Carbon::parse($shift->operation->date) >= \Carbon\Carbon::today())
                                    @php
                                        $count++;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{ $count }}</td>
                        </tr>
                        <tr>
                            <td>Your Total Shifts</td>
                            <td>{{ Auth::user()->operation_shifts()->get()->count() }}</td>
                        </tr>
                        <tr>
                            <td>Your Total Roles</td>
                            <td>{{ Auth::user()->roles()->get()->count() }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
