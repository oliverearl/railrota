@extends('layouts.app')

@php
    $title = 'Role Types';
@endphp
@section('title', $title)

@section('content')
    <div class="container">

        <div class="result-set">
            <h1>{{ $title }}</h1>
        @if ($roleTypes->isEmpty())
                <p>No role types have been defined.</p>
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
                    @foreach ($roleTypes as $roleType)
                        <tr>
                            @if (Auth::user()->isAdmin())
                                <td><a class="btn btn-secondary" href=" {{ route('role_types.show', $roleType->id) }}">View</a></td>
                                <td><a class="btn btn-primary" href=" {{ route('role_types.edit', $roleType->id) }}">Edit</a></td>
                                <td>
                                    <form action="{{ route('role_types.destroy', $roleType->id) }}" method="POST" style="display:inline">
                                        @csrf()
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{ $roleType->name }}</td>
                            @if (is_null($roleType->updated_at))
                                <td><em>Unknown</em></td>
                            @else
                                <td>{{ $roleType->updated_at->format('d/m/Y') }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $roleTypes->links() }}
                </div>
            @endif
        </div>
        @if (Auth::user()->isAdmin())
            <div class="col-md-12 page-action">
                <a class="btn btn-primary" href="{{ route('role_types.create') }}">Add Role Type</a>
            </div>
        @endif
    </div>
@endsection
