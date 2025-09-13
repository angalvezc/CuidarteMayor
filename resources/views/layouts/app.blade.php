<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ancianato - @yield('title')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">Sistema Ancianato</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('residents.index') }}">Residentes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('health_records.index') }}">Historial Médico</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('medications.index') }}">Medicamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('activities.index') }}">Actividades</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('visits.index') }}">Visitas</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {{-- Contenido principal --}}
    <main class="container my-4 flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <small>&copy; {{ date('Y') }} Sistema de Gestión del Ancianato</small>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
