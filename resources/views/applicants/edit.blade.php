@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Editar postulante</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('applicants.show', $applicant) }}" class="btn btn-outline-info btn-sm">Ver detalle</a>
            <a href="{{ route('applicants.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
        </div>
    </div>

    <form method="POST" action="{{ route('applicants.update', $applicant) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('applicants._form')

        @if($applicant->attachments->isNotEmpty())
            <div class="card mb-3">
                <div class="card-header fw-semibold">Adjuntos actuales</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($applicant->attachments as $attachment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $attachment->type }}: {{ $attachment->original_name }}</span>
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
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Actualizar postulante</button>
        </div>
    </form>
@endsection
