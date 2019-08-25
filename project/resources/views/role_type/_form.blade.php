<div class="row">
    <section class="col-lg-6">
        <p>Make modifications to this role type here.</p>
        <form action="{{ route('role_types.update', $roleType->id) }}" method="POST" class="form-group">
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
                       value={{ old('name', $roleType->name) }}
                >
            </div>

            <div class="form-group @if ($errors->has('description')) has-error @endif">
                <label class="" for="notes">Description</label>
                <textarea class="form-control"
                          name="description"
                          id="description"
                          style="resize: none"
                >{{ old('description', $roleType->description) }}</textarea>
            </div>

            <div class="form-group">
                <input class="form-group btn btn-primary" type="submit" value="Submit">
            </div>
        </form>
    </section>
</div>
