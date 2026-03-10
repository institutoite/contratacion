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
        <div class="card-header fw-semibold">Cargos y disponibilidad</div>
        <div class="card-body">
            <div class="row g-2">
                @foreach($positions as $position)
                    <div class="col-md-4">
                        <div class="border rounded p-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $position->name }}</div>
                                <small class="{{ $position->is_active ? 'text-success' : 'text-danger' }}">
                                    {{ $position->is_active ? 'Habilitado' : 'Deshabilitado' }}
                                </small>
                            </div>
                            <form method="POST" action="{{ route('positions.toggle', $position) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $position->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    {{ $position->is_active ? 'Deshabilitar' : 'Habilitar' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-semibold">Buscador y filtros</div>
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('applicants.index') }}">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Nombre, telefono, cargo o correo">
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
