<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte por horario</title>
    <style>
        @page { margin: 26px 30px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #111827; font-size: 11px; }
        .top { border: 1px solid #1f4b70; background: #eaf4ff; padding: 10px; margin-bottom: 10px; }
        .top-table { width: 100%; border-collapse: collapse; }
        .top-table td { border: none; vertical-align: middle; }
        .logo-cell { width: 95px; }
        .logo { width: 78px; height: auto; }
        .title { font-size: 17px; font-weight: 700; margin: 0 0 2px; }
        .muted { color: #315a7c; font-size: 10px; }
        .section-title {
            background: #1f4b70;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            padding: 6px 8px;
            border: 1px solid #1f4b70;
            margin-top: 10px;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d8e6ef; padding: 6px; text-align: left; }
        th { background: #eef6fc; color: #143a57; }
        .summary td { width: 50%; }
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
                    <div class="title">Reporte de postulantes por horario</div>
                    <div class="muted">
                        Horario: {{ $interviewSlot->interview_date->format('d/m/Y') }} {{ \Illuminate\Support\Str::of($interviewSlot->interview_time)->substr(0, 5) }}
                    </div>
                    <div class="muted">Generado: {{ now()->format('d/m/Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Resumen</div>
    <table class="summary">
        <tr>
            <td><strong>Total único por cargo para este horario:</strong> {{ $totalUniqueApplicants ?? 0 }}</td>
            <td><strong>Cargos con postulantes:</strong> {{ $groupedByPosition->count() }}</td>
        </tr>
    </table>

    @forelse($groupedByPosition as $positionName => $items)
        <div class="section-title">{{ $positionName }}</div>
        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Postulante</th>
                    <th>Teléfono</th>
                    <th>Fecha de registro</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $applicant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $applicant->full_name }}</td>
                        <td>{{ $applicant->primary_phone ?: '-' }}</td>
                        <td>{{ $applicant->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $applicant->status ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <div class="section-title">Sin registros</div>
        <table>
            <tbody>
                <tr>
                    <td>No hay postulantes agendados para este horario.</td>
                </tr>
            </tbody>
        </table>
    @endforelse
</body>
</html>
