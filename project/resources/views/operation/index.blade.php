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
    <a class="btn btn-secondary" href="{{ route('operations.glance') }}">Glance View</a>
    <a class="btn btn-info" href="{{ route('operations.pdf') }}">Export to PDF</a>
@endsection

@section('route')
    <div class="container-fluid">
        @if ($operations->isEmpty())
            <p>No operations exist. Start by adding one for today.</p>
            <p><em>In a future release, an operation will be automatically created for the day.</em></p>
        @else
            @foreach ($operations as $operation)
                {{-- Operation --}}
                <section id="operation_{{ $operation->id }}" class="row mb-lg-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <header class="card-header">
                                <h2>{{ \Carbon\Carbon::parse($operation->date)->toFormattedDateString() }}</h2>
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#operation_{{ $operation->id }}_overview">Overview</a>
                                    </li>
                                    {{-- Additional tabs will appear here if shifts exist --}}
                                </ul>
                            </header>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="operation_{{ $operation->id }}_overview">
                                        @if ($operation->is_running)
                                            <h3>Shifts</h3>
                                            <ul>
                                                <li>Shift 1</li>
                                                <li>Shift 2</li>
                                                <li>Shift 3</li>
                                            </ul>
                                            <h3>Notes</h3>
                                            @if(is_null($operation->is_null))
                                                <p><em>There are no notes for this operation.</em></p>
                                            @else
                                                <p>{{ $operation->notes }}</p>
                                            @endif
                                    </div>
                                    @if (Auth::user()->isAdmin())
                                        <div class="page-action">
                                            <a class="btn btn-sm btn-primary" href="#">Add Shift</a>
                                            <a class="btn btn-sm btn-secondary" href="{{ route('operations.edit', $operation->id) }}">Edit Operation</a>
                                            <a class="btn btn-sm btn-outline-danger" href="#">Cancel Operation</a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('operations.destroy', $operation->id) }}">Delete Operation</a>
                                        </div>
                                    @endif
                                    @else
                                        <p class="text-danger"><strong>This operation has been cancelled.</strong></p>
                                        @if (Auth::user()->isAdmin())
                                            <a class="btn btn-sm btn-primary" href="#">Reinstate Operation</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {{-- End Operation --}}
            @endforeach
            <div class="text-center">
                {{ $operations->links() }}
            </div>
        @endif

    </div>
@endsection
