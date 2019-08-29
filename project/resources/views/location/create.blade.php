@extends('layouts._control')

@php
    $title = 'Adding Location';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('locations.index') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <form action="{{ route('locations.store') }}" method="POST" class="form-group">
                @csrf()
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    <label class="" for="name">Name</label>
                    <input class="form-control"
                           type="text"
                           name="name"
                           id="name"
                           minlength="1"
                           maxlength="255"
                           required
                           value="{{ old('name') }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    <label class="" for="description">Description</label>
                    <textarea class="form-control"
                              name="description"
                              id="description"
                              style="resize: none"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <input class="form-group btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </section>
    </div>
@endsection
