@extends('layouts._table')

@php
    $title = "Viewing {$location->name} Location" ?: 'Viewing Location';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href=" {{route('locations.edit', $location->id)}}">Edit</a>
        <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline">
            @csrf()
            @method('delete')
            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('locations.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('table_content')
    <thead>
    <tr>
        <td>Name</td>
        <td>Last Updated</td>
    </tr>
    </thead>
    <tbody>
    <td>{{ $location->name }}</td>
    @if (is_null($location->created_at))
        <td><em>Unknown</em></td>
    @else
        <td>{{ $location->created_at->format('d/m/Y') }}</td>
    @endif
    </tbody>
@endsection

@section('footer')
    <div class="row">
        <section class="col-lg-12">
            <h3>Description</h3>
            <p>{{ $location->description }}</p>
        </section>
    </div>
@endsection
