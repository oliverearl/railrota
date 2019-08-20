<h3>Roles Qualified</h3>
@if ($user->roles->isEmpty())
    <p>{{ $user->name }} does not have any roles.</p>
@else
    <ul>
        @foreach ($user->roles as $role)
            <li><a href="{{ route('role_types.show', $role->role_type->id) }}">{{ $role->role_type->name }}</a></li>
        @endforeach
    </ul>
@endif
