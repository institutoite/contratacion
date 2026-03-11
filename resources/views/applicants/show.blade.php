@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">{{ $applicant->full_name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('applicants.print', $applicant) }}" class="btn btn-outline-primary btn-sm" target="_blank">Imprimir PDF</a>
            <a href="{{ route('applicants.edit', $applicant) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
            <a href="{{ route('applicants.index') }}" class="btn btn-outline-dark btn-sm">Volver</a>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header fw-semibold">Resumen</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Cargo:</strong> {{ $applicant->position?->name ?: '-' }}</p>
                    <p class="mb-1"><strong>Estado:</strong> {{ $applicant->status }}</p>
                    <p class="mb-1"><strong>Valoracion:</strong> {{ $applicant->overall_rating ?: '-' }}</p>
                    <p class="mb-1"><strong>Disponible inmediato:</strong> {{ $applicant->availability_immediate ? 'Si' : 'No' }}</p>
                    <p class="mb-0"><strong>Fecha postulacion:</strong> {{ optional($applicant->application_date)->format('d/m/Y') ?: '-' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header fw-semibold">Datos principales</div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Genero:</strong> {{ $applicant->gender ?: '-' }}</p>
                        <p class="mb-1"><strong>Cedula:</strong> {{ $applicant->identity_number ?: '-' }}</p>
                        <p class="mb-1"><strong>Nacimiento:</strong> {{ optional($applicant->birth_date)->format('d/m/Y') ?: '-' }}</p>
                        <p class="mb-1"><strong>Edad:</strong> {{ $applicant->age ?: '-' }}</p>
                        <p class="mb-1"><strong>Telefono:</strong> {{ $applicant->primary_phone ?: '-' }}</p>
                        <p class="mb-1"><strong>WhatsApp:</strong> {{ $applicant->whatsapp ?: '-' }}</p>
                        <p class="mb-0"><strong>Correo:</strong> {{ $applicant->email ?: '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Direccion:</strong> {{ $applicant->address ?: '-' }}</p>
                        <p class="mb-1"><strong>Zona/Ciudad:</strong> {{ $applicant->city_zone ?: '-' }}</p>
                        <p class="mb-1"><strong>Referencia:</strong> {{ $applicant->reference_name ?: '-' }}</p>
                        <p class="mb-1"><strong>Telefono ref.:</strong> {{ $applicant->reference_phone ?: '-' }}</p>
                        <p class="mb-1"><strong>Parentesco:</strong> {{ $applicant->reference_relationship ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-semibold">Postulacion y perfil</div>
        <div class="card-body row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Modalidad:</strong> {{ $applicant->work_modality ?: '-' }}</p>
                <p class="mb-1"><strong>Horario:</strong> {{ $applicant->availability_schedule ?: '-' }}</p>
                <p class="mb-1"><strong>Pretension salarial:</strong> {{ $applicant->salary_expectation ?: '-' }}</p>
                <p class="mb-1"><strong>Conocio por:</strong> {{ $applicant->vacancy_source ?: '-' }}</p>
                <p class="mb-1"><strong>Motivacion:</strong> {{ $applicant->motivation_text ?: '-' }}</p>
                <p class="mb-1"><strong>Experiencia previa:</strong> {{ is_null($applicant->has_experience) ? '-' : ($applicant->has_experience ? 'Si' : 'No') }}</p>
                <p class="mb-1"><strong>Anios experiencia:</strong> {{ $applicant->experience_years ?: '-' }}</p>
                <p class="mb-0"><strong>Portafolio:</strong> @if($applicant->portfolio_link)<a href="{{ $applicant->portfolio_link }}" target="_blank">{{ $applicant->portfolio_link }}</a>@else - @endif</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Nivel de estudios:</strong> {{ $applicant->education_level ?: '-' }}</p>
                <p class="mb-1"><strong>Institucion:</strong> {{ $applicant->educational_institution ?: '-' }}</p>
                <p class="mb-1"><strong>Cursos:</strong> {{ $applicant->courses_certifications ?: '-' }}</p>
                <p class="mb-1"><strong>Habilidades:</strong> {{ $applicant->main_skills ?: '-' }}</p>
                <p class="mb-1"><strong>Fortalezas:</strong> {{ $applicant->strengths ?: '-' }}</p>
                <p class="mb-1"><strong>Debilidades:</strong> {{ $applicant->weaknesses ?: '-' }}</p>
                <p class="mb-0"><strong>Observaciones:</strong> {{ $applicant->internal_notes ?: '-' }}</p>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-semibold">Documentos adjuntos</div>
                <div class="card-body">
                    @if($applicant->attachments->isEmpty())
                        <p class="text-muted mb-0">No hay archivos adjuntos.</p>
                    @else
                        <ul class="list-group">
                            @foreach($applicant->attachments as $attachment)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $attachment->type }}</div>
                                        <small>{{ $attachment->original_name }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('attachments.download', $attachment) }}" class="btn btn-sm btn-outline-primary">Descargar</a>
                                        <form method="POST" action="{{ route('attachments.destroy', $attachment) }}" onsubmit="return confirm('Eliminar adjunto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-semibold">Registrar entrevista</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('applicants.interviews.store', $applicant) }}">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Fecha *</label>
                                <input type="date" name="interview_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora</label>
                                <input type="time" name="interview_time" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Entrevistador</label>
                                <input type="text" name="interviewer_name" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Valoracion</label>
                                <select name="rating" class="form-select">
                                    <option value="">-</option>
                                    @foreach($ratings as $rating)
                                        <option value="{{ $rating }}">{{ $rating }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Estado posterior</label>
                                <select name="status_after_interview" class="form-select">
                                    <option value="">Sin cambio</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recomendado</label>
                                <select name="recommended" class="form-select">
                                    <option value="">Sin definir</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Resultado de entrevista</label>
                                <textarea name="result" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fortalezas</label>
                                <textarea name="strengths" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Debilidades</label>
                                <textarea name="weaknesses" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Observaciones</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-primary btn-sm">Guardar entrevista</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-semibold">Historial de entrevistas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Entrevistador</th>
                            <th>Valoracion</th>
                            <th>Resultado</th>
                            <th>Estado posterior</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicant->interviews as $interview)
                            <tr>
                                <td>{{ optional($interview->interview_date)->format('d/m/Y') }}</td>
                                <td>{{ $interview->interview_time ?: '-' }}</td>
                                <td>{{ $interview->interviewer_name ?: '-' }}</td>
                                <td>{{ $interview->rating ?: '-' }}</td>
                                <td>{{ $interview->result ?: '-' }}</td>
                                <td>{{ $interview->status_after_interview ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">No hay entrevistas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-semibold">Historial de cambios</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Accion</th>
                            <th>Usuario</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicant->histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $history->action }}</td>
                                <td>{{ $history->performed_by ?: '-' }}</td>
                                <td>
                                    @if($history->note)
                                        <div>{{ $history->note }}</div>
                                    @endif
                                    @if($history->changes)
                                        <small class="text-muted">{{ json_encode($history->changes, JSON_UNESCAPED_UNICODE) }}</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3">Sin historial disponible.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
