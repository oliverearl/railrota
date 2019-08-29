<thead>
<tr>
    <th>Operation</th>
    <th>Running</th>
    <th>Shifts</th>
    <th>Vacancies</th>
    @foreach ($roleTypes as $roleType)
        <th>{{ $roleType->name }}</th>
    @endforeach
</tr>
</thead>
<tbody>
@foreach ($operations as $operation)
    @php
        $operationDate = \Carbon\Carbon::parse($operation->date);
    @endphp
    <tr>
        {{-- Date --}}
        <td><a href=" {{ route('operations.show', $operation->id) }}">{{ $operationDate->format('d/m/y') }}</a></td>
        {{-- Running --}}
        @if (!($operation->is_running))
            <td class="text-danger">No</td>
        @else
            <td class="text-success">Yes</td>
        @endif
        {{-- Shifts --}}
        <td>{{ $operation->operation_shifts->count() }}</td>
        {{-- Vacancies --}}
        @php
            // Not amazing, but it'll do
            $count = 0
        @endphp
        @foreach ($operation->operation_shifts as $shift)
            @if (is_null($shift->user_id))
                @php
                    $count++;
                @endphp
            @endif
        @endforeach
        <td>{{ $count }}</td>
        {{-- Shifts --}}
        @if ($operation->operation_shifts->isEmpty())
            @foreach ($roleTypes as $roleType)
                <td></td>
            @endforeach
        @else
            @foreach ($roleTypes as $roleType)
                <td>
                    <ul style="list-style: none; padding-left: 0;">
                        @foreach($operation->operation_shifts as $shift)
                            @if ($shift->role_type->name === $roleType->name)
                                @if (is_null($shift->user_id))
                                    @if (\Carbon\Carbon::today() > $operationDate || !$operation->is_running)
                                        <li><em>Unfulfilled</em></li>
                                    @else
                                        <form action="{{ route('operations.shifts.register', [$operation->id, $shift->id]) }}" method="POST" style="display:inline">
                                            @csrf()
                                            @method('patch')
                                            <button type="submit" class="btn btn-outline-primary">Vacant</button>
                                        </form>
                                    @endif
                                @else
                                    <li><a href="{{ route('users.show', $shift->user->id) }}">{{ $shift->user->name }} {{ $shift->user->surname }}</a></li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </td>
            @endforeach
        @endif
    </tr>
@endforeach
</tbody>
