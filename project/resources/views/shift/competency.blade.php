@extends('layouts._control')

@php
    $formattedDate = \Carbon\Carbon::parse($operation->date)->format('d/m/y');
    $title = "Editing {$operationShift->role_type->name} Competency Requirements on {$formattedDate}"
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a href="{{ route('role_competencies.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> Add Role Competency</a>
    <a class="btn btn-outline-secondary" href="{{ route('operations.show', $operation->id) }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-md-12">
            <form action="{{ route('operations.shifts.update', [$operation->id, $operationShift->id]) }}" method="POST" class="form-group">
                @csrf()
                @method('patch')
                <div class="form-group @if ($errors->has('role_type_id')) has-error @endif">
                    <h3>Associated Competency</h3>
                    <p>Only volunteers with an equal or greater grade will be able to volunteer for this shift.</p>
                    <p>This is determined by numerical tiers, as defined in the <a href="{{ route('role_competencies.index') }}">role competences index.</a></p>
                    <p>The requirement system is optional. If you do not want to specify a required competency level, click <strong>Proceed Without</strong>.</p>
                    @if (!$operationShift->role_type->role_competencies->isEmpty())
                    <label for="role_competency_id">Role Competency</label>
                    <select name="role_competency_id" id="role_competency_id" class="form-control" required>
                        @foreach($operationShift->role_type->role_competencies as $competency)
                            <option value="{{ $competency->id }}" @if ($competency->id === $operationShift->role_competency_id) {{'selected="selected"'}} @endif>
                                {{ $competency->name }} - (Tier {{ $competency->tier }})
                            </option>
                        @endforeach
                    </select>
                    @else
                        <p><strong>There are no competencies set for this role.</strong></p>
                    @endif
                </div>

                <div class="form-group">
                    <button class="form-group btn btn-primary" type="submit"><i class="fas fa-save"></i> Submit</button>
                    <a class="form-group btn btn-danger" href="{{ route('operations.show', $operation->id) }}"><i class="fas fa-times-circle"></i> Proceed Without</a>
                </div>
            </form>
        </section>
    </div>
@endsection
