@extends('layouts.app')

@php
    $title = 'Locations';
@endphp
@section('title', $title)

@section('content')
    <div class="container">

        <div class="result-set">
            <h1>{{ $title }}</h1>
            @if ($locations->isEmpty())
                <p>No locations have been defined.</p>
            @else
                <table class="table table-bordered table-striped table-hover" id="data-table">
                    <thead>
                    <tr>
                        <th>View</th>
                        @if (Auth::user()->isAdmin())
                            <th>Edit</th>
                            <th>Delete</th>
                        @endif
                        <th>Name</th>
                        <th>Last Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            <td><a class="btn btn-secondary" href=" {{ route('locations.show', $location->id) }}">View</a></td>
                            @if (Auth::user()->isAdmin())
                                <td><a class="btn btn-primary" href=" {{ route('locations.edit', $location->id) }}">Edit</a></td>
                                <td>
                                    <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline">
                                        @csrf()
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{ $location->name }}</td>
                            @if (is_null($location->updated_at))
                                <td><em>Unknown</em></td>
                            @else
                                <td>{{ $location->updated_at->format('d/m/Y') }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>
        @if (Auth::user()->isAdmin())
            <div class="col-md-12 page-action">
                <a class="btn btn-primary" href="{{ route('locations.create') }}">Add Location</a>
            </div>
        @endif
    </div>
@endsection
