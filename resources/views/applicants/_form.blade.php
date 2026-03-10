@php
    $selectedStatus = old('status', $applicant->status ?? 'Nuevo');
@endphp

<div class="card mb-3">
    <div class="card-header fw-semibold">Datos personales</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Nombre completo *</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $applicant->full_name) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Genero</label>
            <select name="gender" class="form-select">
                <option value="">Seleccionar</option>
                <option value="hombre" @selected(old('gender', $applicant->gender) === 'hombre')>Hombre</option>
                <option value="mujer" @selected(old('gender', $applicant->gender) === 'mujer')>Mujer</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Cedula de identidad</label>
            <input type="text" name="identity_number" class="form-control" value="{{ old('identity_number', $applicant->identity_number) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($applicant->birth_date)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Edad</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $applicant->age) }}">
        </div>
        <div class="col-md-5">
            <label class="form-label">Direccion completa</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $applicant->address) }}">
        </div>
        <div class="col-md-5">
            <label class="form-label">Zona o ciudad</label>
            <input type="text" name="city_zone" class="form-control" value="{{ old('city_zone', $applicant->city_zone) }}">
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header fw-semibold">Contacto y referencias</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Telefono principal</label>
            <input type="text" name="primary_phone" class="form-control" value="{{ old('primary_phone', $applicant->primary_phone) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $applicant->whatsapp) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Correo electronico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $applicant->email) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Familiar de referencia</label>
            <input type="text" name="reference_name" class="form-control" value="{{ old('reference_name', $applicant->reference_name) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Telefono del familiar</label>
            <input type="text" name="reference_phone" class="form-control" value="{{ old('reference_phone', $applicant->reference_phone) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Parentesco</label>
            <input type="text" name="reference_relationship" class="form-control" value="{{ old('reference_relationship', $applicant->reference_relationship) }}">
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header fw-semibold">Postulacion</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Cargo</label>
            <select name="position_id" class="form-select">
                <option value="">Seleccionar</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" @selected(old('position_id', $applicant->position_id) == $position->id)>
                        {{ $position->name }} {{ $position->is_active ? '' : '(deshabilitado)' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Fecha de postulacion</label>
            <input type="date" name="application_date" class="form-control" value="{{ old('application_date', optional($applicant->application_date)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Modalidad</label>
            <select name="work_modality" class="form-select">
                <option value="">Seleccionar</option>
                @foreach($modalities as $modality)
                    <option value="{{ $modality }}" @selected(old('work_modality', $applicant->work_modality) === $modality)>{{ $modality }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Disponibilidad horaria</label>
            <input type="text" name="availability_schedule" class="form-control" value="{{ old('availability_schedule', $applicant->availability_schedule) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Disponibilidad inmediata</label>
            <select name="availability_immediate" class="form-select">
                <option value="">Sin definir</option>
                <option value="1" @selected(old('availability_immediate', $applicant->availability_immediate) === true || old('availability_immediate', $applicant->availability_immediate) === 1 || old('availability_immediate', $applicant->availability_immediate) === '1')>Si</option>
                <option value="0" @selected(old('availability_immediate', $applicant->availability_immediate) === false || old('availability_immediate', $applicant->availability_immediate) === 0 || old('availability_immediate', $applicant->availability_immediate) === '0')>No</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Pretension salarial</label>
            <input type="number" step="0.01" name="salary_expectation" class="form-control" value="{{ old('salary_expectation', $applicant->salary_expectation) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Medio donde conocio la vacante</label>
            <input type="text" name="vacancy_source" class="form-control" value="{{ old('vacancy_source', $applicant->vacancy_source) }}">
        </div>
        <div class="col-12">
            <label class="form-label">Por que le gustaria trabajar con nosotros</label>
            <textarea name="motivation_text" class="form-control" rows="2">{{ old('motivation_text', $applicant->motivation_text) }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Experiencia previa</label>
            <select name="has_experience" class="form-select">
                <option value="">Sin definir</option>
                <option value="1" @selected(old('has_experience', $applicant->has_experience) === true || old('has_experience', $applicant->has_experience) === 1 || old('has_experience', $applicant->has_experience) === '1')>Si</option>
                <option value="0" @selected(old('has_experience', $applicant->has_experience) === false || old('has_experience', $applicant->has_experience) === 0 || old('has_experience', $applicant->has_experience) === '0')>No</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Anios de experiencia</label>
            <input type="number" step="0.1" name="experience_years" class="form-control" value="{{ old('experience_years', $applicant->experience_years) }}">
        </div>
        <div class="col-12">
            <label class="form-label">Resumen de experiencia laboral</label>
            <textarea name="experience_summary" class="form-control" rows="2">{{ old('experience_summary', $applicant->experience_summary) }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nivel de estudios</label>
            <input type="text" name="education_level" class="form-control" value="{{ old('education_level', $applicant->education_level) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Institucion educativa</label>
            <input type="text" name="educational_institution" class="form-control" value="{{ old('educational_institution', $applicant->educational_institution) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Portafolio (enlace)</label>
            <input type="url" name="portfolio_link" class="form-control" value="{{ old('portfolio_link', $applicant->portfolio_link) }}">
        </div>
        <div class="col-12">
            <label class="form-label">Cursos o certificaciones</label>
            <textarea name="courses_certifications" class="form-control" rows="2">{{ old('courses_certifications', $applicant->courses_certifications) }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Habilidades principales</label>
            <textarea name="main_skills" class="form-control" rows="2">{{ old('main_skills', $applicant->main_skills) }}</textarea>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header fw-semibold">Documentos</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Hoja de vida / CV</label>
            <input type="file" name="cv_file" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Foto del postulante</label>
            <input type="file" name="photo_file" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Certificados (multiples)</label>
            <input type="file" name="certificates[]" class="form-control" multiple>
        </div>
        <div class="col-md-6">
            <label class="form-label">Otros archivos</label>
            <input type="file" name="other_files[]" class="form-control" multiple>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header fw-semibold">Evaluacion</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Estado</label>
            <select name="status" class="form-select">
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Valoracion (1 a 5)</label>
            <select name="overall_rating" class="form-select">
                <option value="">Sin valoracion</option>
                @foreach($ratings as $rating)
                    <option value="{{ $rating }}" @selected((string) old('overall_rating', $applicant->overall_rating) === (string) $rating)>{{ $rating }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Recomendado para contratacion</label>
            <select name="recommended" class="form-select">
                <option value="">Sin definir</option>
                <option value="1" @selected(old('recommended', $applicant->recommended) === true || old('recommended', $applicant->recommended) === 1 || old('recommended', $applicant->recommended) === '1')>Si</option>
                <option value="0" @selected(old('recommended', $applicant->recommended) === false || old('recommended', $applicant->recommended) === 0 || old('recommended', $applicant->recommended) === '0')>No</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fortalezas</label>
            <textarea name="strengths" class="form-control" rows="2">{{ old('strengths', $applicant->strengths) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Debilidades</label>
            <textarea name="weaknesses" class="form-control" rows="2">{{ old('weaknesses', $applicant->weaknesses) }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Observaciones internas</label>
            <textarea name="internal_notes" class="form-control" rows="3">{{ old('internal_notes', $applicant->internal_notes) }}</textarea>
        </div>
    </div>
</div>
