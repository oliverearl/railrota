@extends('layouts._control')

@php
    $title = 'Glance View';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-info" href="{{ route('operations.pdf') }}">Export to PDF</a>
    <a class="btn btn-outline-secondary" href="{{ route('operations.index') }}">Back</a>
@endsection

@section('route')
    <div class="container">
        <div class="result-set">
            @if ($operations->isEmpty())
                <p>No operations have been defined.</p>
            @else
                @include('operation._glance_table')
                <div class="text-center">
                    {{ $operations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
