@extends('layouts._control')

@php
    $title = "Editing {$roleCompetency->name} Role Competency" ?: 'Editing Role Competency';
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('role_competencies.index') }}">Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-lg-6">
            <p>Make modifications to this role competency here.</p>
            <form action="{{ route('role_competencies.update', $roleCompetency->id) }}" method="POST" class="form-group">
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
                           value="{{ old('name', $roleCompetency->name) }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('role_type_id')) has-error @endif">
                    <label for="role_type_id">Associated role type</label>
                    <select name="role_type_id" id="role_type_id" class="form-control" required>
                        @foreach($roleTypes as $roleType)
                            <option value="{{ $roleType->id }}"
                            @if ($roleType->id === $roleCompetency->role_type_id) {{'selected="selected"'}} @endif>
                                {{ $roleType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group @if ($errors->has('tier')) has-error @endif">
                    <label class="" for="tier">Tier</label>
                    <input class="form-control"
                           type="number"
                           name="tier"
                           id="tier"
                           min="1"
                           max="10"
                           required
                           value="{{ old('tier', $roleCompetency->tier) }}"
                    >
                </div>

                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    <label class="" for="description">Description</label>
                    <textarea class="form-control"
                              name="description"
                              id="description"
                              style="resize: none"
                    >{{ old('description', $roleCompetency->description) }}</textarea>
                </div>

                <div class="form-group">
                    <input class="form-group btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </section>
    </div>
@endsection
