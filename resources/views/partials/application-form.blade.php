@php
    $prefix = $prefix ?? 'apply';
@endphp

<form method="POST" action="{{ route('applications.store') }}" class="row g-3" novalidate>
    @csrf
    <div class="col-md-6">
        <label class="form-label" for="{{ $prefix }}_full_name">Nombre completo</label>
        <input type="text" id="{{ $prefix }}_full_name" name="full_name" class="form-control" value="{{ old('full_name') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="{{ $prefix }}_gender">Genero</label>
        <select id="{{ $prefix }}_gender" name="gender" class="form-select">
            <option value="">Seleccionar</option>
            <option value="hombre" @selected(old('gender') === 'hombre')>Hombre</option>
            <option value="mujer" @selected(old('gender') === 'mujer')>Mujer</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label" for="{{ $prefix }}_position_id">Cargo que deseas ocupar</label>
        <select id="{{ $prefix }}_position_id" name="position_id" class="form-select">
            <option value="">Seleccionar cargo</option>
            @forelse($positions as $position)
                <option value="{{ $position->id }}" @selected((string) old('position_id') === (string) $position->id)>
                    {{ $position->name }}
                </option>
            @empty
                <option value="" disabled>No hay cargos activos disponibles</option>
            @endforelse
        </select>
    </div>
    <div class="col-12">
        <label class="form-label" for="{{ $prefix }}_address">Direccion</label>
        <input type="text" id="{{ $prefix }}_address" name="address" class="form-control" value="{{ old('address') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="{{ $prefix }}_primary_phone">Telefono</label>
        <input type="text" id="{{ $prefix }}_primary_phone" name="primary_phone" class="form-control" value="{{ old('primary_phone') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="{{ $prefix }}_reference_phone">Telefono referencia</label>
        <input type="text" id="{{ $prefix }}_reference_phone" name="reference_phone" class="form-control" value="{{ old('reference_phone') }}">
    </div>
    <div class="col-12">
        <label class="form-label" for="{{ $prefix }}_motivation_text">Por que te gustaria trabajar con nosotros</label>
        <textarea id="{{ $prefix }}_motivation_text" name="motivation_text" class="form-control" rows="4">{{ old('motivation_text') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label" for="{{ $prefix }}_interview_slot">Fecha y hora de entrevista</label>
        <select id="{{ $prefix }}_interview_slot" name="interview_slot_id" class="form-select">
            <option value="">Seleccionar fecha y hora</option>
            @forelse($slots as $slot)
                <option value="{{ $slot->id }}" @selected((string) old('interview_slot_id') === (string) $slot->id)>
                    {{ $slot->interview_date->format('d/m/Y') }} - {{ \Illuminate\Support\Str::of($slot->interview_time)->substr(0, 5) }}
                </option>
            @empty
                <option value="" disabled>No hay horarios disponibles por ahora</option>
            @endforelse
        </select>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary w-100">Enviar registro</button>
    </div>
</form>
