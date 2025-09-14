<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuidarteMayor - @yield('title')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                    <i class="bi bi-heart-pulse-fill me-2 text-danger"></i> CuidarteMayor
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="bi bi-people-fill me-1"></i>Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}"><i class="bi bi-person-badge-fill me-1"></i>Roles</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('health_records.index') }}"><i class="bi bi-file-earmark-medical-fill me-1"></i>Historial Médico</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('residents.index') }}"><i class="bi bi-house-heart-fill me-1"></i>Residentes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('medications.index') }}"><i class="bi bi-capsule-pill me-1"></i>Medicamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('visits.index') }}"><i class="bi bi-calendar-heart-fill me-1"></i>Visitas</a></li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {{-- Contenido dinámico --}}
    <main class="container my-4 flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer con iconos --}}
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-1">
                <i class="bi bi-hospital-fill text-danger me-1"></i>
                <strong>CuidarteMayor</strong> - Sistema de gestión para hogares geriátricos
            </p>
            <small class="d-block mt-2">&copy; {{ date('Y') }} CuidarteMayor - Todos los derechos reservados</small>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
