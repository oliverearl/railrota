@extends('layouts._control')

@php
    $title = 'Calendar View';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href="{{ route('operations.create') }}"><i class="fas fa-plus-square"></i> Add New Operation</a>
    @endif
    <a class="btn btn-secondary" href="{{ route('operations.pdf') }}"><i class="fas fa-file-pdf"></i> Export to PDF</a>
@endsection

@section('route')
    <div class="container">
        <div class="result-set">
            @if ($operations->isEmpty())
                <p>No operations have been defined.</p>
            @else
                <table class="table table-bordered table-striped table-hover" id="data-table">
                    @include('operation._glance_table')
                </table>
                <div class="text-center">
                    {{ $operations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
