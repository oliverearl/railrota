@extends('layouts._control')

@php
    $title = "Editing {$role->user->name}'s {$role->role_type->name} Role" ?: 'Editing Role';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('roles.index') }}">Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <p>Make modifications to the current grade here.</p>
            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="form-group">
                @method('patch')
                @include('layouts._errors')
                @csrf()
                <input type="hidden" name="role_type_id" id="role_type_id" value="{{ $role->role_type->id }}" required>
                <div class="form-group @if ($errors->has('role_competency_id')) has-error @endif">
                    <label for="role_competency_id">Role competencies</label>
                    <select name="role_competency_id" id="role_competency_id" class="form-control" required>
                        @foreach($competencies as $competency)
                                <option value="{{ $competency->id }}"
                                @if ($competency->id === $role->role_competency_id) {{'selected="selected"'}} @endif>
                                    {{ $competency->name }}
                                </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input class="form-group btn btn-primary" type="submit" value="Save">
                </div>
            </form>
        </section>
    </div>
@endsection
