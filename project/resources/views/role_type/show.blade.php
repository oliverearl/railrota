@extends('layouts._table')

@php
    $title = "Viewing {$roleType->name} Role Type" ?: 'Viewing Record';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href=" {{route('role_types.edit', $roleType->id)}}"><i class="fas fa-edit"></i> Edit</a>
        <form action="{{ route('role_types.destroy', $roleType->id) }}" method="POST" style="display:inline">
            @csrf()
            @method('delete')
            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('role_types.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('table_content')
    @if (!$competencies->isEmpty())
        <thead>
        <tr>
            <td>Competencies</td>
            <td>Tier</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($competencies as $competency)
            <tr>
                <td><a href="{{ route('role_competencies.show', $competency->id) }}">{{ $competency->name }}</a></td>
                <td>{{ $competency->tier }}</td>
            </tr>
        @endforeach
        </tbody>
    @else
        <p>There are no competencies assigned to this role type.</p>
    @endif
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href="{{ route('role_competencies.create') }}"><i class="fas fa-plus-square"></i> Add Competency</a>
    @endif
@endsection

@section('footer')
    <div class="row">
        <section class="col-lg-12">
            <h3>Description</h3>
            <p>{{ $roleType->description }}</p>
        </section>
    </div>
@endsection
