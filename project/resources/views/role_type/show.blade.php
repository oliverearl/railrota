@extends('layouts._table')

@php
    $title = "Viewing {$roleType->name} Role Type" ?: 'Viewing Record';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href=" {{route('role_types.edit', $roleType->id)}}">Edit</a>
        <form action="{{ route('role_types.destroy', $roleType->id) }}" method="POST" style="display:inline">
            @csrf()
            @method('delete')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('role_types.index') }}">Back</a>
@endsection

@section('table_content')
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
@endsection

@section('footer')
    <div class="row">
        <section class="col-lg-12">
            <h3>Description</h3>
            <p>{{ $roleType->description }}</p>
        </section>
    </div>
@endsection
