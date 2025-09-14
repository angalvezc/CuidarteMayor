<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuidarteMayor - @yield('title')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">CuidarteMayor</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">

                    @auth
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('residents.index') }}">Residentes</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('health_records.index') }}">Historial Médico</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('medications.index') }}">Medicamentos</a></li>

                        </ul>
                        @endauth
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                                </li>
                            @endif
                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
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

    {{-- Contenido principal --}}
    <main class="container my-4 flex-grow-1">
        {{-- Sección de bienvenida --}}
        <div class="text-center mb-4">
            <h1>Bienvenido a CuidarteMayor</h1>
            <p class="lead">Gestiona de manera eficiente los residentes, su historial médico, medicamentos y visitas en nuestro sistema.</p>
        </div>

        {{-- Accesos rápidos --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Residentes</h5>
                        <p class="card-text">Consulta y administra la información de los residentes del ancianato.</p>
                        <a href="{{ route('residents.index') }}" class="btn btn-primary">Ver Residentes</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Historial Médico</h5>
                        <p class="card-text">Accede a los registros médicos y controla la salud de los residentes.</p>
                        <a href="{{ route('health_records.index') }}" class="btn btn-primary">Ver Historial</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Medicamentos</h5>
                        <p class="card-text">Registra y administra los medicamentos de cada residente.</p>
                        <a href="{{ route('medications.index') }}" class="btn btn-primary">Ver Medicamentos</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contenido adicional dinámico --}}
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <small>&copy; {{ date('Y') }} CuidarteMayor - Todos los derechos reservados</small>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
