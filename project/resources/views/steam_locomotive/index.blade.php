@extends('layouts.app')

@php
    $title = 'Steam Locomotives';
@endphp
@section('title', $title)

@section('content')
    <div class="container">

        <div class="result-set">
            <h1>{{ $title }}</h1>
            @if ($steamLocomotives->isEmpty())
                <p>No locomotives have been defined.</p>
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
                    @foreach ($steamLocomotives as $steamLocomotive)
                        <tr>
                            <td><a class="btn btn-secondary" href=" {{ route('steam_locomotives.show', $steamLocomotive->id) }}">View</a></td>
                            @if (Auth::user()->isAdmin())
                                <td><a class="btn btn-primary" href=" {{ route('steam_locomotives.edit', $steamLocomotive->id) }}">Edit</a></td>
                                <td>
                                    <form action="{{ route('steam_locomotives.destroy', $steamLocomotive->id) }}" method="POST" style="display:inline">
                                        @csrf()
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{ $steamLocomotive->name }}</td>
                            @if (is_null($steamLocomotive->updated_at))
                                <td><em>Unknown</em></td>
                            @else
                                <td>{{ $steamLocomotive->updated_at->format('d/m/Y') }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $steamLocomotives->links() }}
                </div>
            @endif
        </div>
        @if (Auth::user()->isAdmin())
            <div class="col-md-12 page-action">
                <a class="btn btn-primary" href="{{ route('steam_locomotives.create') }}">Add Locomotive</a>
            </div>
        @endif
    </div>
@endsection
