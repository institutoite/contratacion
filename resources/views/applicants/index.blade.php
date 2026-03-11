@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Panel de postulantes</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('applicants.export', request()->query()) }}" class="btn btn-success btn-sm">Exportar CSV</a>
            <a href="{{ route('applicants.create') }}" class="btn btn-primary btn-sm">Nuevo postulante</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-semibold">CRUD de cargos</div>
        <div class="card-body">
            <form class="row g-2 mb-3" method="POST" action="{{ route('positions.store') }}">
                @csrf
                <div class="col-md-8">
                    <label class="form-label">Nuevo cargo</label>
                    <input type="text" name="name" class="form-control" placeholder="Ejemplo: Analista de admisiones" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Agregar cargo</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Cargo</th>
                            <th>Estado</th>
                            <th style="min-width: 360px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($positions as $position)
                            <tr>
                                <td>
                                    <form method="POST" action="{{ route('positions.update', $position) }}" class="d-flex gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $position->name }}" required>
                                        <button class="btn btn-sm btn-outline-primary">Guardar</button>
                                    </form>
                                </td>
                                <td>
                                    @if($position->is_active)
                                        <span class="badge text-bg-success">Activo</span>
                                    @else
                                        <span class="badge text-bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form method="POST" action="{{ route('positions.toggle', $position) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm {{ $position->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                {{ $position->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('positions.destroy', $position) }}" onsubmit="return confirm('Eliminar cargo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3">No hay cargos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-semibold">Horarios de entrevistas (landing publica)</div>
        <div class="card-body">
            <form class="row g-2 mb-3" method="POST" action="{{ route('interview-slots.store') }}">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="interview_date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hora</label>
                    <input type="time" name="interview_time" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Agregar horario</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Agendados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($interviewSlots as $slot)
                            @php
                                $bookingsCount = \App\Models\ApplicantInterview::query()
                                    ->whereDate('interview_date', $slot->interview_date)
                                    ->where('interview_time', $slot->interview_time)
                                    ->count();
                            @endphp
                            <tr>
                                <td>{{ $slot->interview_date->format('d/m/Y') }}</td>
                                <td>{{ \Illuminate\Support\Str::of($slot->interview_time)->substr(0, 5) }}</td>
                                <td>
                                    @if($slot->is_active)
                                        <span class="badge text-bg-success">Activo</span>
                                    @else
                                        <span class="badge text-bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bookingsCount > 0)
                                        <span class="text-body-secondary">{{ $bookingsCount }} postulante(s)</span>
                                    @else
                                        <span class="text-success">Sin agendados</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form method="POST" action="{{ route('interview-slots.toggle', $slot) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm {{ $slot->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                {{ $slot->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('interview-slots.destroy', $slot) }}" onsubmit="return confirm('Eliminar horario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">Aun no se registraron horarios de entrevista.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $interviewSlots->links() }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-semibold">Buscador y filtros</div>
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('applicants.index') }}">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" value="{{ $filters['search'] ?? ($filters['q'] ?? '') }}" placeholder="Buscar por nombre o telefono">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="position_id">
                        <option value="">Todos los cargos</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" @selected(($filters['position_id'] ?? '') == $position->id)>{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status">
                        <option value="">Todos los estados</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form-select" name="overall_rating">
                        <option value="">Val.</option>
                        @foreach($ratings as $rating)
                            <option value="{{ $rating }}" @selected((string)($filters['overall_rating'] ?? '') === (string)$rating)>{{ $rating }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form-select" name="availability_immediate">
                        <option value="">Disp.</option>
                        <option value="1" @selected(($filters['availability_immediate'] ?? '') === '1')>Si</option>
                        <option value="0" @selected(($filters['availability_immediate'] ?? '') === '0')>No</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button class="btn btn-primary btn-sm">Filtrar</button>
                    <a href="{{ route('applicants.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-semibold">Listado</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Contacto</th>
                            <th>Cargo</th>
                            <th>Estado / Valoracion</th>
                            <th>Fecha postulacion</th>
                            <th>Disponibilidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicants as $applicant)
                            <tr>
                                <td>{{ $applicant->full_name }}</td>
                                <td>
                                    <div>{{ $applicant->primary_phone ?: '-' }}</div>
                                    <small class="text-muted">{{ $applicant->email ?: '-' }}</small>
                                </td>
                                <td>{{ $applicant->position?->name ?: '-' }}</td>
                                <td style="min-width: 210px;">
                                    <form method="POST" action="{{ route('applicants.quick-update', $applicant) }}" class="d-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status }}" @selected($applicant->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <select name="overall_rating" class="form-select form-select-sm" style="max-width: 72px;">
                                            <option value="">-</option>
                                            @foreach($ratings as $rating)
                                                <option value="{{ $rating }}" @selected((string)$applicant->overall_rating === (string)$rating)>{{ $rating }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-outline-primary">OK</button>
                                    </form>
                                </td>
                                <td>{{ optional($applicant->application_date)->format('d/m/Y') ?: '-' }}</td>
                                <td>{{ $applicant->availability_immediate ? 'Si' : 'No' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('applicants.show', $applicant) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                        <a href="{{ route('applicants.print', $applicant) }}" class="btn btn-sm btn-outline-primary" target="_blank">PDF</a>
                                        <a href="{{ route('applicants.edit', $applicant) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                        <form method="POST" action="{{ route('applicants.destroy', $applicant) }}" onsubmit="return confirm('Eliminar postulante?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No se encontraron postulantes con los filtros actuales.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $applicants->links() }}
        </div>
    </div>
@endsection
