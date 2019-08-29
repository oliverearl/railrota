@extends('layouts._table')

@php
    $title = "Viewing {$roleCompetency->name} Role Competency" ?: 'Viewing Role Competency';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    {{-- Buttons go here --}}
    @if (Auth::user()->isAdmin())
        {{-- Edit --}}
        <a class="btn btn-primary" href=" {{route('role_competencies.edit', $roleCompetency->id)}}"><i class="fas fa-edit"></i> Edit</a>
        <form action="{{ route('role_competencies.destroy', $roleCompetency->id) }}" method="POST" style="display:inline">
            @csrf()
            @method('delete')
            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('role_competencies.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('table_content')
    <thead>
    <tr>
        <th>Keys</th>
        <th>Values</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Name</td>
        <td>{{ $roleCompetency->name }}</td>
    </tr>
    <tr>
        <td>Associated Role Type</td>
        <td><a href="{{ route('role_types.show', $roleCompetency->role_type->id) }}">{{ $roleCompetency->role_type->name }}</a></td>
    </tr>
    <tr>
        <td>Tier</td>
        <td>{{ $roleCompetency->tier }}</td>
    </tr>
    <tr>
        <td>Date Last Modified</td>
        @if (is_null($roleCompetency->updated_at))
            <td><em>Unknown</em></td>
        @else
            <td>{{ $roleCompetency->updated_at->format('d/m/Y') }}</td>
        @endif
    </tr>
    <tr>

        <td>Date Created</td>
        @if (is_null($roleCompetency->created_at))
            <td><em>Unknown</em></td>
        @else
            <td>{{ $roleCompetency->created_at->format('d/m/Y') }}</td>
        @endif
    </tr>
    </tbody>
@endsection

@section('footer')
    <div class="row">
        <section class="col-lg-12">
            <h3>Description</h3>
            <p>{{ $roleCompetency->description }}</p>
        </section>
    </div>
@endsection
