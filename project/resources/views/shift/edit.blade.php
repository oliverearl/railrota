@extends('layouts._control')

@php
    $formattedDate = \Carbon\Carbon::parse($operation->date)->format('d/m/y');
    $title = "Editing {$operationShift->role_type->name} Shift on {$formattedDate}"
@endphp

@section('title', $title)
@section('subtitle', $title)

@section('buttons')
    <a class="btn btn-outline-secondary" href="{{ route('operations.show', $operation->id) }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
@endsection

@section('route')
    <div class="row">
        <section class="col-md-12">
            <form action="{{ route('operations.shifts.update', [$operation->id, $operationShift->id]) }}" method="POST" class="form-group">
                @csrf()
                @method('patch')
                <div class="form-group @if ($errors->has('role_type_id')) has-error @endif">
                    <h3>Role Type</h3>
                    <p>Only volunteers with this role type will be able to sign up to volunteer.</p>
                    <label for="role_type_id">Role Type</label>
                    <select name="role_type_id" id="role_type_id" class="form-control" required>
                        @foreach($data['role_types'] as $roleType)
                            <option value="{{ $roleType->id }}" @if ($roleType->id === $operationShift->role_type_id) {{'selected="selected"'}} @endif>
                                {{ $roleType->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="page-action mt-sm-2 mb-sm-1">
                        <a href="{{ route('role_types.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> Add Role Type</a>
                    </div>
                    <small><strong>NB: </strong><em>You will set the required competency / grade level on the next screen.</em></small>
                </div>

                <div class="form-group @if ($errors->has('location_id')) has-error @endif">
                    <h3>Locations</h3>
                    <p>Does the shift have an associated location? If so, choose one.</p>
                    <label for="location_id">Location</label>
                    <select name="location_id" id="location_id" class="form-control">
                        <option value="">Not Applicable</option>
                        @foreach($data['locations'] as $location)
                            <option value="{{ $location->id }}" @if ($location->id === $operationShift->location_id) {{'selected="selected"'}} @endif>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="page-action mt-sm-2 mb-sm-1">
                        <a href="{{ route('locations.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> Add Location</a>
                    </div>
                </div>

                <div class="form-group @if ($errors->has('powered_locomotive_id')) has-error @endif">
                    <h3>Diesel or Electric Locomotives</h3>
                    <p>If the shift has an associated diesel or electric locomotive, please select it here.</p>
                    <p class="text-danger">Do not select more than one type of locomotive.</p>
                    <label for="powered_locomotive_id">Diesel or Electric Locomotive</label>
                    <select name="powered_locomotive_id" id="powered_locomotive_id" class="form-control">
                        <option value="" selected="selected">Not Applicable</option>
                        @foreach($data['powered_locomotives'] as $locomotive)
                            <option value="{{ $locomotive->id }}" @if ($locomotive->id === $operationShift->powered_locomotive_id) {{'selected="selected"'}} @endif>
                                {{ $locomotive->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="page-action mt-sm-2 mb-sm-1">
                        <a href="{{ route('powered_locomotives.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> Add Locomotive</a>
                    </div>
                </div>

                <div class="form-group @if ($errors->has('steam_locomotive_id')) has-error @endif">
                    <h3>Steam Locomotives</h3>
                    <p>Similarly, if the shift involves a steam-powered locomotive, please select it here.</p>
                    <p class="text-danger">Do not select more than one type of locomotive.</p>
                    <label for="steam_locomotive_id">Steam Locomotive</label>
                    <select name="steam_locomotive_id" id="steam_locomotive_id" class="form-control">
                        <option value="" selected="selected">Not Applicable</option>
                        @foreach($data['steam_locomotives'] as $locomotive)
                            <option value="{{ $locomotive->id }}" @if ($locomotive->id === $operationShift->steam_locomotive_id) {{'selected="selected"'}} @endif>
                                {{ $locomotive->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="page-action mt-sm-2 mb-sm-1">
                        <a href="{{ route('steam_locomotives.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> Add Locomotive</a>
                    </div>
                </div>


                <div class="form-group @if ($errors->has('steam_locomotive_id')) has-error @endif">
                    <h3>Pre-Assigned Volunteer</h3>
                    <p>If you know in advance who will be volunteering for this shift, you can sign them up here.</p>
                    <p class="text-danger"><strong>You</strong> are responsible for ensuring the volunteer is suitable to work this shift.</p>
                    <label for="user_id">Steam Locomotive</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="" selected="selected">Leave Vacant</option>
                        @foreach($data['users'] as $user)
                            <option value="{{ $user->id }}" @if ($user->id === $operationShift->user_id) {{'selected="selected"'}} @endif>
                                {{ $user->name }} {{ $user->surname }}
                            </option>
                        @endforeach
                    </select>
                    <div class="page-action mt-sm-2 mb-sm-1">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i> Add User</a>
                    </div>
                </div>

                <div class="form-group @if ($errors->has('notes')) has-error @endif">
                    <h3>Notes</h3>
                    <p>You can add optional notes or custom requirements for this shift here.</p>
                    <label class="" for="notes">Notes</label>
                    <textarea class="form-control"
                              name="notes"
                              id="notes"
                              style="resize: none"
                    >{{ old('notes', $operationShift->notes) }}</textarea>
                </div>

                <div class="form-group">
                    <button class="form-group btn btn-primary" type="submit"><i class="fas fa-save"></i> Submit</button>
                </div>
            </form>
        </section>
    </div>
@endsection
