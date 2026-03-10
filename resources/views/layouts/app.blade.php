<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Postulantes</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/brand-theme.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ auth()->check() ? route('applicants.index') : route('welcome') }}">Postulaciones</a>
            <div class="d-flex gap-2">
                @auth
                    <a class="btn btn-outline-light btn-sm" href="{{ route('applicants.create') }}">Nuevo postulante</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm">Cerrar sesion</button>
                    </form>
                @else
                    <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Login admin</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-app">
                <strong>Se encontraron errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
