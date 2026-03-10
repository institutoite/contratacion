@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Registrar postulante</h1>
        <a href="{{ route('applicants.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
    </div>

    <form method="POST" action="{{ route('applicants.store') }}" enctype="multipart/form-data">
        @csrf
        @include('applicants._form')

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Guardar postulante</button>
        </div>
    </form>
@endsection
