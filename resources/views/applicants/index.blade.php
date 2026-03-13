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

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="h6 mb-0">Horarios disponibles</h3>
                <small class="text-body-secondary">Cada horario incluye su reporte PDF</small>
            </div>

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
                                        <a href="{{ route('interview-slots.report', $slot) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            Reporte PDF
                                        </a>
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
                                    @php
                                        $waRawPhone = $applicant->whatsapp ?: $applicant->primary_phone;
                                        $waPhone = $waRawPhone ? preg_replace('/\D+/', '', $waRawPhone) : null;
                                        $waMessage = rawurlencode('Hola ' . ($applicant->full_name ?: '') . ', te escribimos de ITE. Nos dejaste tus datos en nuestro sistema de postulaciones y queremos continuar con tu proceso.');
                                        $waUrl = $waPhone ? 'https://wa.me/' . $waPhone . '?text=' . $waMessage : 'https://web.whatsapp.com/';
                                    @endphp
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('applicants.show', $applicant) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                        <a href="{{ route('applicants.print', $applicant) }}" class="btn btn-sm btn-outline-primary" target="_blank">PDF</a>
                                        <a href="{{ $waUrl }}" class="btn btn-sm btn-success" target="_blank" rel="noopener noreferrer" title="Enviar WhatsApp">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
                                                <path d="M19.11 17.21c-.26-.13-1.53-.75-1.77-.84-.24-.09-.41-.13-.59.13-.18.26-.67.84-.82 1.01-.15.18-.31.2-.57.07-.26-.13-1.09-.4-2.07-1.27-.77-.69-1.28-1.54-1.43-1.8-.15-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.15.18-.26.26-.44.09-.18.04-.33-.02-.46-.07-.13-.59-1.42-.81-1.95-.22-.52-.44-.45-.59-.45-.15-.01-.33-.01-.5-.01-.18 0-.46.07-.7.33-.24.26-.92.9-.92 2.2s.94 2.56 1.07 2.74c.13.18 1.85 2.82 4.49 3.95.63.27 1.12.43 1.5.55.63.2 1.2.17 1.65.1.5-.07 1.53-.63 1.75-1.24.22-.61.22-1.13.15-1.24-.06-.11-.24-.17-.5-.3M16 3C8.83 3 3 8.83 3 16c0 2.28.6 4.51 1.74 6.48L3 29l6.69-1.75A12.96 12.96 0 0 0 16 29c7.17 0 13-5.83 13-13S23.17 3 16 3m0 23.66c-2.07 0-4.1-.56-5.87-1.63l-.42-.25-3.97 1.04 1.06-3.87-.27-.4a10.63 10.63 0 0 1-1.66-5.57c0-5.88 4.79-10.66 10.67-10.66 2.85 0 5.53 1.11 7.55 3.12 2.01 2.02 3.12 4.7 3.12 7.55 0 5.88-4.78 10.67-10.66 10.67"/>
                                            </svg>
                                        </a>
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
