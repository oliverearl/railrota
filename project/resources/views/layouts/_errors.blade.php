@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-success alert-dismissible fade show" id="formMessage" role="alert">
            {{ $error }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach
@endif
