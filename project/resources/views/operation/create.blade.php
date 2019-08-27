@extends('layouts._control')

@php
    $title = 'Adding Operation';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('operations.index') }}">Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <form action="{{ route('operations.store') }}" method="POST" class="form-group">
                @csrf()
                <div class="form-group @if ($errors->has('date')) has-error @endif">
                    <label class="" for="date">Date of Operation</label>
                    <input class="form-control"
                           type="date"
                           name="date"
                           id="date"
                           required
                           value="{{ old('date', \Carbon\Carbon::today())->format('y-m-d') }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('notes')) has-error @endif">
                    <label class="" for="notes">Notes</label>
                    <textarea class="form-control"
                              name="notes"
                              id="notes"
                              style="resize: none"
                    >{{ old('notes') }}</textarea>
                </div>

                <div class="form-group">
                    <input class="form-group btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </section>
    </div>
@endsection
