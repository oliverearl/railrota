<table class="table table-bordered table-striped table-hover" id="data-table">
    <thead>
    <tr>
        <th>Date</th>
        <th>Shift Cancelled?</th>
        <th>Number of Shifts</th>
        <th>Vacancies?</th>
        <th>Last Updated</th>
        <th>Date Created</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($operations as $operation)
        <tr>
            <td>{{ \Carbon\Carbon::parse($operation->date)->toFormattedDateString()  }}</td>
            @if (is_null($operation->is_running))
                <td class="text-danger">Yes</td>
            @else
                <td class="text-success">No</td>
            @endif
            <td>{{ $operation->operation_shifts->count() }}</td>
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
            <td>{{ $operation->updated_at->format('d/m/y') }}</td>
            <td>{{ $operation->created_at->format('d/m/y') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
