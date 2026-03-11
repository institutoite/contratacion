<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de postulación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
            color: #1f2937;
        }
        .sheet {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 18px;
        }
        h1 {
            margin: 0 0 10px;
            font-size: 24px;
        }
        h2 {
            margin: 16px 0 8px;
            font-size: 18px;
        }
        .row {
            margin-bottom: 6px;
        }
        .label {
            font-weight: 700;
        }
        .actions {
            margin-top: 16px;
        }
        @media print {
            .actions {
                display: none;
            }
            body {
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <div class="sheet">
        <h1>Comprobante de registro</h1>
        <div class="row"><span class="label">Fecha de impresión:</span> {{ now()->format('d/m/Y H:i') }}</div>

        <h2>Horario programado</h2>
        @if($scheduledInterview)
            <div class="row"><span class="label">Fecha:</span> {{ optional($scheduledInterview->interview_date)->format('d/m/Y') ?: '-' }}</div>
            <div class="row"><span class="label">Hora:</span> {{ $scheduledInterview->interview_time ? \Illuminate\Support\Str::of($scheduledInterview->interview_time)->substr(0, 5) : '-' }}</div>
        @else
            <div class="row">No se encontró un horario programado.</div>
        @endif

        <h2>Datos registrados</h2>
        <div class="row"><span class="label">Nombre completo:</span> {{ $applicant->full_name }}</div>
        <div class="row"><span class="label">Teléfono:</span> {{ $applicant->primary_phone ?: '-' }}</div>
        <div class="row"><span class="label">Género:</span> {{ $applicant->gender ?: '-' }}</div>
        <div class="row"><span class="label">Cargo:</span> {{ $applicant->position?->name ?: '-' }}</div>
        <div class="row"><span class="label">Dirección:</span> {{ $applicant->address ?: '-' }}</div>
        <div class="row"><span class="label">Teléfono de referencia:</span> {{ $applicant->reference_phone ?: '-' }}</div>
        <div class="row"><span class="label">Fecha de registro:</span> {{ optional($applicant->application_date)->format('d/m/Y') ?: '-' }}</div>

        <div class="actions">
            <button onclick="window.print()">Imprimir / Guardar PDF</button>
        </div>
    </div>
</body>
</html>
