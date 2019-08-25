@include('layouts._errors')
@csrf()
<h3>Personal Data</h3>
<div class="form-group @if ($errors->has('name')) has-error @endif">
    <label class="" for="name">First Name</label>
    <input class="form-control"
           type="text"
           name="name"
           id="name"
           minlength="1"
           maxlength="255"
           required
           value={{ old('name', $user->name) }}
    >
</div>

<div class="form-group @if ($errors->has('surname')) has-error @endif">
    <label class="" for="surname">Surname</label>
    <input class="form-control"
           type="text"
           name="surname"
           id="surname"
           minlength="1"
           maxlength="255"
           value={{ old('surname', $user->surname) }}
    >
</div>

<div class="form-group @if ($errors->has('email')) has-error @endif">
    <label class="" for="email">Email Address</label>
    <input class="form-control"
           type="email"
           name="email"
           id="email"
           minlength="1"
           maxlength="255"
           required
           value={{ old('email', $user->email) }}
    >
</div>

<div class="form-group @if ($errors->has('phone_home')) has-error @endif">
    <label class="" for="phone_home">Home Telephone</label>
    <input class="form-control"
           type="tel"
           name="phone_home"
           id="phone_home"
           minlength="1"
           maxlength="255"
           value={{ old('phone_home', $user->phone_home) }}
    >
</div>

<div class="form-group @if ($errors->has('phone_work')) has-error @endif">
    <label class="" for="phone_work">Work Telephone</label>
    <input class="form-control"
           type="tel"
           name="phone_work"
           id="phone_work"
           minlength="1"
           maxlength="255"
           value={{ old('phone_work', $user->phone_work) }}
    >
</div>

<div class="form-group @if ($errors->has('phone_mobile')) has-error @endif">
    <label class="" for="phone_mobile">Mobile Telephone</label>
    <input class="form-control"
           type="tel"
           name="phone_mobile"
           id="phone_mobile"
           minlength="1"
           maxlength="255"
           value={{ old('phone_mobile', $user->phone_mobile) }}
    >
</div>

<div class="form-group form-check @if ($errors->has('is_available')) has-error @endif">
    <input class="form-check-input"
           type="checkbox"
           name="is_available"
           id="is_available"
           value="1"
           @if ($user->is_available === 1)
               checked="checked"
           @endif
    >
    <label class="form-check-label" for="is_available">Currently available to volunteer</label>
</div>

<div class="form-group @if ($errors->has('notes')) has-error @endif">
    <label class="" for="notes">Additional Notes</label>
    <textarea class="form-control"
              name="notes"
              id="notes"
              style="resize: none"
              >{{ old('notes', $user->notes) }}</textarea>
</div>

@if (Auth::user()->isAdmin())
    {{-- Admin Only Controls --}}
    <h3>Admin-Only Controls</h3>
    <p><em>Only an administrator can modify these fields.</em></p>
    <div class="form-group @if ($errors->has('date_of_last_inspection')) has-error @endif">
        <label for="date_of_last_inspection">Date of Last Inspection</label>
        <input class="form-control"
               type="date"
               name="date_of_last_inspection"
               id="date_of_last_inspection"
               value="{{ old('date_of_last_inspection', $user->date_of_last_inspection) }}"
        >
    </div>

    <p class="text-danger">Be <strong>really</strong> careful with this one.</p>
    <div class="form-group form-check @if ($errors->has('is_admin')) has-error @endif">

        <input class="form-check-input"
               type="checkbox"
               name="is_admin"
               id="is_admin"
               value="1"
               @if ($user->is_admin === 1)
               checked="checked"
            @endif
        >
        <label class="form-check-label" for="is_admin">Administrator Status</label>
    </div>
@endif

<div class="form-group">
    <input class="form-group btn btn-primary" type="submit" value="Submit">
</div>
