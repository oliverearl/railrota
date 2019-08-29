@extends('layouts._control')

@php
    $title = 'Operations';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href="{{ route('operations.create') }}">Add New Operation</a>
    @endif
    <a class="btn btn-secondary" href="{{ route('operations.pdf') }}">Export to PDF</a>
@endsection

@section('route')
    <div class="container-fluid">
        @if ($operations->isEmpty())
            <p>No operations exist. Start by adding one for today.</p>
            <p><em>In a future release, an operation will be automatically created for the day.</em></p>
        @else
            @foreach ($operations as $operation)
                {{-- Operation --}}
                @include('operation._operation')
                {{-- End Operation --}}
            @endforeach
            <div class="text-center">
                {{ $operations->links() }}
            </div>
        @endif

    </div>
@endsection
