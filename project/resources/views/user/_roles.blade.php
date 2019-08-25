<h3>Roles Qualified</h3>
@if ($user->roles->isEmpty())
    <p>{{ $user->name }} does not have any roles.</p>
@else
    <ul>
        @foreach ($user->roles as $role)
            <li><a href="{{ route('role_types.show', $role->role_type->id) }}">{{ $role->role_type->name }}</a>
                @if (!is_null($role->role_competency))
                    <a href="{{ route('role_competencies.show', $role->role_competency->id) }}">({{ $role->role_competency->name }})</a>
                @endif</li>
        @endforeach
    </ul>
@endif
