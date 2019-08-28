<section id="operation_{{ $operation->id }}" class="row mb-lg-3">
    <div class="col-lg-12">
        <div class="card">
            <header class="card-header">
                <h2><a href="{{ route('operations.show', $operation->id) }}">{{ \Carbon\Carbon::parse($operation->date)->toFormattedDateString() }}</a></h2>
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#operation_{{ $operation->id }}_overview">Overview</a>
                    </li>
                    @if (!$operation->operation_shifts->isEmpty())
                        @foreach ($operation->operation_shifts as $shift)
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#operation_{{ $operation->id }}__{{ $shift->id }}">{{ $shift->role_type->name ?: 'Shift' }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </header>
            <div class="card-body">
                <div class="tab-content" style="border: solid 1px #ddd; padding: 10px;">
                    <div role="tabpanel" class="tab-pane active" id="operation_{{ $operation->id }}_overview">
                        @if ($operation->is_running)
                            <h3>Shifts</h3>
                            @if ($operation->operation_shifts->isEmpty())
                                <p><em>There are no shifts assigned to this operation.</em></p>
                            @else
                                <p>There are {{ $operation->operation_shifts->count() }} shifts assigned to this operation.</p>
                                <ul>
                                    @foreach ($operation->operation_shifts as $shift)
                                        <li><a href="#operation_{{ $operation->id }}__{{ $shift->id }}">{{ $shift->role_type->name }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <h3>Notes</h3>
                            @if (is_null($operation->notes))
                                <p><em>There are no notes for this operation.</em></p>
                            @else
                                <p>{{ $operation->notes }}</p>
                            @endif
                            @if (Auth::user()->isAdmin())
                                <div class="page-action mb-sm-3">
                                    <a class="btn btn-sm btn-primary" href="{{ route('operations.shifts.create', $operation->id) }}">Add Shift</a>
                                </div>
                            @endif
                    </div>
                    @if (!$operation->operation_shifts->isEmpty())
                        @foreach($operation->operation_shifts as $shift)
                            <div role="tabpanel" class="tab-pane border-secondary" id="operation_{{ $operation->id }}__{{ $shift->id }}">
                                <h3>{{ $shift->role_type->name }}</h3>
                                <ul>
                                    @if (is_null($shift->user_id))
                                        <li><strong>This shift is vacant!</strong></li>
                                    @else
                                        <li>This shift is staffed by <a href="{{ route('users.show', $shift->user_id) }}">{{ "{$shift->user->name} {$shift->user->surname}" }}.</a></li>
                                    @endif
                                    @if (is_null($shift->role_competency_id))
                                        <li><em>No grade / competency requirement was specified.</em></li>
                                    @else
                                        <li>It requires a grade of <a href="{{ route('role_competencies.show', $shift->role_competency_id) }}">{{ $shift->role_competency->name }}</a> (tier {{ $shift->role_competency->tier }}) or above to fulfill.</li>
                                    @endif
                                    @if (!is_null($shift->steam_locomotive_id))
                                        <li>This shift covers <a href="{{ route('steam_locomotives.show', $shift->steam_locomotive_id) }}">{{ $shift->steam_locomotive->name }}</a></li>
                                    @elseif (!is_null($shift->powered_locomotive_id))
                                        <li>This shift covers <a href="{{ route('powered_locomotives.show', $shift->powered_locomotive_id) }}">{{ $shift->powered_locomotive->name }}</a></li>
                                    @endif
                                    @if (!is_null($shift->location_id))
                                        <li>This shift is located at <a href="{{ route('locations.show', $shift->location_id) }}">{{ $shift->location->name }}</a></li>
                                    @endif
                                </ul>
                                <div class="page-action mb-sm-3">
                                    @if (is_null($shift->user_id))
                                        <form action="{{ route('operations.shifts.register', [$operation->id, $shift->id]) }}" method="POST" style="display:inline">
                                            @csrf()
                                            @method('patch')
                                            <button type="submit" class="btn btn-outline-primary">Volunteer for this Shift</button>
                                        </form>
                                    @elseif ($shift->user_id === Auth::id())
                                        <form action="{{ route('operations.shifts.deregister', [$operation->id, $shift->id]) }}" method="POST" style="display:inline">
                                            @csrf()
                                            @method('patch')
                                            <button type="submit" class="btn btn-outline-primary">Pull out of this Shift</button>
                                        </form>
                                    @endif
                                </div>
                                @if (Auth::user()->isAdmin())
                                    <div class="page-action mb-sm-3">
                                        <h4>Shift Controls</h4>
                                        <a class="btn btn-sm btn-primary" href="{{ route('operations.shifts.create', $operation->id) }}">Add Shift</a>
                                        <a class="btn btn-sm btn-secondary" href="{{ route('operations.shifts.edit', [$operation->id, $shift->id]) }}">Edit Shift</a>
                                        <form action="{{ route('operations.shifts.destroy', [$operation->id, $shift->id]) }}" method="POST" style="display:inline">
                                            @csrf()
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete Shift</button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    @endif
                    @else
                        <p class="text-danger"><strong>This operation has been cancelled.</strong></p>
                        @if (Auth::user()->isAdmin())
                            <a class="btn btn-sm btn-primary" href="{{ route('operations.edit', $operation->id) }}">Reinstate Operation</a>
                        @endif
                    @endif
                </div>
                @if (Auth::user()->isAdmin())
                    <div class="page-action" style="padding-top: 10px">
                        <h4>Operation Controls</h4>
                        <a class="btn btn-secondary" href="{{ route('operations.edit', $operation->id) }}">Edit Operation</a>
                        <form action="{{ route('operations.destroy', $operation->id) }}" method="POST" style="display:inline">
                            @csrf()
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete Operation</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
