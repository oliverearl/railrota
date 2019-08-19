<!-- Name -->
<div class="form-group @if ($errors->has('name')) has-error @endif">
    <label class="" for="name">First Name</label>
    <input class="form-control" type="text" name="name" value={{ $user->name }}>
</div>
