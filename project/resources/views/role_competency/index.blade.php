@extends('layouts.app')

@php
    $title = 'Role Competencies';
@endphp
@section('title', $title)

@section('content')
    <div class="container">

        <div class="result-set">
            <h1>{{ $title }}</h1>
            @if ($roleCompetencies->isEmpty())
                <p>No role competencies have been defined.</p>
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
                        <th>Associated Role Type</th>
                        <th>Tier</th>
                        <th>Last Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($roleCompetencies as $roleCompetency)
                        <tr>
                            @if (Auth::user()->isAdmin())
                                <td><a class="btn btn-secondary" href=" {{ route('role_competencies.show', $roleCompetency->id) }}">View</a></td>
                                <td><a class="btn btn-primary" href=" {{ route('role_competencies.edit', $roleCompetency->id) }}">Edit</a></td>
                                <td>
                                    <form action="{{ route('role_competencies.destroy', $roleCompetency->id) }}" method="POST" style="display:inline">
                                        @csrf()
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            @endif
                            <td>{{ $roleCompetency->name }}</td>
                            <td>{{ $roleCompetency->role_type->name }}</td>
                            <td>{{ $roleCompetency->tier }}</td>
                            @if (is_null($roleCompetency->updated_at))
                                <td><em>Unknown</em></td>
                            @else
                                <td>{{ $roleCompetency->updated_at->format('d/m/Y') }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $roleCompetencies->links() }}
                </div>
            @endif
        </div>
        @if (Auth::user()->isAdmin())
            <div class="col-md-12 page-action">
                <a class="btn btn-primary" href="{{ route('role_competencies.create') }}">Add Role Competency</a>
            </div>
        @endif
    </div>
@endsection
