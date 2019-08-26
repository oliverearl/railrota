@extends('layouts.app')

@php
    $title = 'Diesel and Electric Locomotives';
@endphp
@section('title', $title)

@section('content')
    <div class="container">

        <div class="result-set">
            <h1>{{ $title }}</h1>
            @if ($poweredLocomotives->isEmpty())
                <p>No locomotives have been defined.</p>
            @else
                <table class="table table-bordered table-striped table-hover" id="data-table">
                    <thead>
                    <tr>
                        @if (Auth::user()->isAdmin())
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        @endif
                        <th>Name</th>
                        <th>Last Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($poweredLocomotives as $poweredLocomotive)
                        <tr>
                            @if (Auth::user()->isAdmin())
                                <td><a class="btn btn-secondary" href=" {{ route('powered_locomotives.show', $poweredLocomotive->id) }}">View</a></td>
                                <td><a class="btn btn-primary" href=" {{ route('powered_locomotives.edit', $poweredLocomotive->id) }}">Edit</a></td>
                                <td>
                                    <form action="{{ route('powered_locomotives.destroy', $poweredLocomotive->id) }}" method="POST" style="display:inline">
                                        @csrf()
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{ $poweredLocomotive->name }}</td>
                            @if (is_null($poweredLocomotive->updated_at))
                                <td><em>Unknown</em></td>
                            @else
                                <td>{{ $poweredLocomotive->updated_at->format('d/m/Y') }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $poweredLocomotives->links() }}
                </div>
            @endif
        </div>
        @if (Auth::user()->isAdmin())
            <div class="col-md-12 page-action">
                <a class="btn btn-primary" href="{{ route('powered_locomotives.create') }}">Add Locomotive</a>
            </div>
        @endif
    </div>
@endsection
