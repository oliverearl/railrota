@extends('layouts._control')

@php
    $title = 'Editing Operation';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('operations.index') }}">Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <form action="{{ route('operations.update', $operation->id) }}" method="POST" class="form-group">
                @csrf()
                @method('patch')
                <div class="form-group @if ($errors->has('date')) has-error @endif">
                    <label class="" for="date">Date of Operation</label>
                    <input class="form-control"
                           type="date"
                           name="date"
                           id="date"
                           required
                           value="{{ old('date', $operation->date) }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('notes')) has-error @endif">
                    <label class="" for="notes">Notes</label>
                    <textarea class="form-control"
                              name="notes"
                              id="notes"
                              style="resize: none"
                    >{{ old('notes', $operation->notes) }}</textarea>
                </div>

                <div class="form-group form-check @if ($errors->has('is_running')) has-error @endif">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_running"
                           id="is_running"
                           value="1"
                       @if ($operation->is_running === 1)
                           checked="checked"
                        @endif
                    >
                    <label class="form-check-label" for="is_running">Shift Running?</label>
                </div>

                <div class="form-group">
                    <input class="form-group btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </section>
    </div>
@endsection
