<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de postulante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            margin: 24px;
        }

        h1, h2 {
            margin: 0 0 10px;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 20px;
            margin-bottom: 16px;
        }

        .section {
            margin-top: 18px;
        }

        .label {
            font-weight: bold;
        }

        .print-actions {
            margin-top: 20px;
        }

        @media print {
            .print-actions {
                display: none;
            }
            body {
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ficha de postulante</h1>
        <div>Fecha de impresion: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="section">
        <h2>Horario programado</h2>
        @if($scheduledInterview)
            <div class="grid">
                <div><span class="label">Fecha:</span> {{ optional($scheduledInterview->interview_date)->format('d/m/Y') }}</div>
                <div><span class="label">Hora:</span> {{ $scheduledInterview->interview_time ? \Illuminate\Support\Str::of($scheduledInterview->interview_time)->substr(0, 5) : '-' }}</div>
                <div><span class="label">Entrevistador:</span> {{ $scheduledInterview->interviewer_name ?: '-' }}</div>
                <div><span class="label">Estado posterior:</span> {{ $scheduledInterview->status_after_interview ?: '-' }}</div>
            </div>
        @else
            <div>No hay un horario de entrevista registrado para este postulante.</div>
        @endif
    </div>

    <div class="section">
        <h2>Datos del postulante</h2>
        <div class="grid">
            <div><span class="label">Nombre:</span> {{ $applicant->full_name }}</div>
            <div><span class="label">Cargo:</span> {{ $applicant->position?->name ?: '-' }}</div>
            <div><span class="label">Telefono:</span> {{ $applicant->primary_phone ?: '-' }}</div>
            <div><span class="label">WhatsApp:</span> {{ $applicant->whatsapp ?: '-' }}</div>
            <div><span class="label">Correo:</span> {{ $applicant->email ?: '-' }}</div>
            <div><span class="label">Cedula:</span> {{ $applicant->identity_number ?: '-' }}</div>
            <div><span class="label">Direccion:</span> {{ $applicant->address ?: '-' }}</div>
            <div><span class="label">Zona/Ciudad:</span> {{ $applicant->city_zone ?: '-' }}</div>
            <div><span class="label">Estado:</span> {{ $applicant->status ?: '-' }}</div>
            <div><span class="label">Valoracion:</span> {{ $applicant->overall_rating ?: '-' }}</div>
            <div><span class="label">Fecha de postulacion:</span> {{ optional($applicant->application_date)->format('d/m/Y') ?: '-' }}</div>
            <div><span class="label">Disponibilidad inmediata:</span> {{ $applicant->availability_immediate ? 'Si' : 'No' }}</div>
        </div>
    </div>

    <div class="section">
        <h2>Resumen profesional</h2>
        <p><span class="label">Experiencia:</span> {{ $applicant->experience_summary ?: '-' }}</p>
        <p><span class="label">Habilidades:</span> {{ $applicant->main_skills ?: '-' }}</p>
        <p><span class="label">Observaciones internas:</span> {{ $applicant->internal_notes ?: '-' }}</p>
    </div>

    <div class="print-actions">
        <button onclick="window.print()">Imprimir / Guardar en PDF</button>
    </div>
</body>
</html>
