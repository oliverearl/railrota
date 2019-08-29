@extends('layouts._table')

@php
    $title = "Viewing {$poweredLocomotive->name} Locomotive" ?: 'Viewing Locomotive';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    @if (Auth::user()->isAdmin())
        <a class="btn btn-primary" href=" {{route('powered_locomotives.edit', $poweredLocomotive->id)}}"><i class="fas fa-edit"></i> Edit</a>
        <form action="{{ route('powered_locomotives.destroy', $poweredLocomotive->id) }}" method="POST" style="display:inline">
            @csrf()
            @method('delete')
            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('powered_locomotives.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('table_content')
    <thead>
    <tr>
        <td>Name</td>
        <td>Last Updated</td>
    </tr>
    </thead>
    <tbody>
    <td>{{ $poweredLocomotive->name }}</td>
    @if (is_null($poweredLocomotive->created_at))
        <td><em>Unknown</em></td>
    @else
        <td>{{ $poweredLocomotive->created_at->format('d/m/Y') }}</td>
    @endif
    </tbody>
@endsection

@section('footer')
    <div class="row">
        <section class="col-lg-12">
            <h3>Description</h3>
            <p>{{ $poweredLocomotive->description }}</p>
        </section>
    </div>
@endsection
