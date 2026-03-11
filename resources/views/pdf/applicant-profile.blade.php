<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de postulante</title>
    <style>
        @page { margin: 26px 30px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #111827; font-size: 11px; }
        .top { border: 1px solid #1f4b70; background: #eaf4ff; padding: 10px; margin-bottom: 10px; }
        .top-table { width: 100%; border-collapse: collapse; }
        .top-table td { border: none; vertical-align: middle; }
        .logo-cell { width: 95px; }
        .logo { width: 78px; height: auto; }
        .title { font-size: 19px; font-weight: 700; }
        .muted { color: #315a7c; font-size: 10px; }
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .grid td { border: 1px solid #b6cfdf; padding: 6px; vertical-align: top; background: #f7fbff; }
        .section-title { background: #1f4b70; color: #ffffff; font-weight: 700; text-transform: uppercase; font-size: 10px; padding: 6px 8px; border: 1px solid #1f4b70; margin-top: 8px; }
        .kv { width: 100%; border-collapse: collapse; }
        .kv td { border: 1px solid #d8e6ef; padding: 6px; vertical-align: top; }
        .k { width: 28%; font-weight: 700; background: #eef6fc; color: #143a57; }
        .v { width: 72%; }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('images/logo.png');
        $logoData = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
    @endphp

    <div class="top">
        <table class="top-table">
            <tr>
                <td class="logo-cell">
                    @if($logoData)
                        <img src="{{ $logoData }}" alt="Logo" class="logo">
                    @else
                        <strong>LOGO</strong>
                    @endif
                </td>
                <td>
                    <div class="title">Ficha de Postulante</div>
                    <div class="muted">Generado el {{ now()->format('d/m/Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="grid">
        <tr>
            <td>
                <strong>Nombre</strong><br>{{ $applicant->full_name }}
            </td>
            <td>
                <strong>Cargo</strong><br>{{ $applicant->position?->name ?: '-' }}
            </td>
            <td>
                <strong>Estado</strong><br>{{ $applicant->status ?: '-' }}
            </td>
            <td>
                <strong>Valoración</strong><br>{{ $applicant->overall_rating ?: '-' }}
            </td>
        </tr>
    </table>

    <div class="section-title">Horario de entrevista</div>
    <table class="kv">
        <tr>
            <td class="k">Fecha</td>
            <td class="v">{{ $scheduledInterview ? optional($scheduledInterview->interview_date)->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="k">Hora</td>
            <td class="v">{{ $scheduledInterview && $scheduledInterview->interview_time ? \Illuminate\Support\Str::of($scheduledInterview->interview_time)->substr(0, 5) : '-' }}</td>
        </tr>
        <tr>
            <td class="k">Entrevistador</td>
            <td class="v">{{ $scheduledInterview?->interviewer_name ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Datos personales y contacto</div>
    <table class="kv">
        <tr><td class="k">Cédula</td><td class="v">{{ $applicant->identity_number ?: '-' }}</td></tr>
        <tr><td class="k">Teléfono</td><td class="v">{{ $applicant->primary_phone ?: '-' }}</td></tr>
        <tr><td class="k">WhatsApp</td><td class="v">{{ $applicant->whatsapp ?: '-' }}</td></tr>
        <tr><td class="k">Correo</td><td class="v">{{ $applicant->email ?: '-' }}</td></tr>
        <tr><td class="k">Dirección</td><td class="v">{{ $applicant->address ?: '-' }}</td></tr>
        <tr><td class="k">Zona/Ciudad</td><td class="v">{{ $applicant->city_zone ?: '-' }}</td></tr>
    </table>

    <div class="section-title">Perfil profesional</div>
    <table class="kv">
        <tr><td class="k">Modalidad</td><td class="v">{{ $applicant->work_modality ?: '-' }}</td></tr>
        <tr><td class="k">Disponibilidad</td><td class="v">{{ $applicant->availability_schedule ?: '-' }}</td></tr>
        <tr><td class="k">Pretensión salarial</td><td class="v">{{ $applicant->salary_expectation ?: '-' }}</td></tr>
        <tr><td class="k">Nivel de estudios</td><td class="v">{{ $applicant->education_level ?: '-' }}</td></tr>
        <tr><td class="k">Experiencia</td><td class="v">{{ $applicant->experience_summary ?: '-' }}</td></tr>
        <tr><td class="k">Habilidades</td><td class="v">{{ $applicant->main_skills ?: '-' }}</td></tr>
        <tr><td class="k">Observaciones</td><td class="v">{{ $applicant->internal_notes ?: '-' }}</td></tr>
    </table>
</body>
</html>
