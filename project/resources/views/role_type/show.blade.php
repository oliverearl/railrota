@extends('layouts._control')

@section('title', $roleType->name)
@section('subtitle', $roleType->name)

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

@section('route')
    <p>{{ $roleType->description }}</p>
@endsection
