@extends('layouts._control')

@php
    $title = "Editing {$location->name} Location" ?: 'Editing Location';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('locations.index') }}">Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <p>Make modifications to this location here.</p>
            <form action="{{ route('locations.update', $location->id) }}" method="POST" class="form-group">
                @csrf()
                @method('patch')
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    <label class="" for="name">Name</label>
                    <input class="form-control"
                           type="text"
                           name="name"
                           id="name"
                           minlength="1"
                           maxlength="255"
                           required
                           value="{{ old('name', $location->name) }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    <label class="" for="description">Description</label>
                    <textarea class="form-control"
                              name="description"
                              id="description"
                              style="resize: none"
                    >{{ old('description', $location->description) }}</textarea>
                </div>

                <div class="form-group">
                    <input class="form-group btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </section>
    </div>
@endsection
