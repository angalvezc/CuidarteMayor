<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ancianato - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header>
        <h1>Ancianato - Sistema de Gestión</h1>
        <nav>
            <a href="{{ route('users.index') }}">Usuarios</a>
            <a href="{{ route('roles.index') }}">Roles</a>
            <a href="{{ route('residents.index') }}">Residentes</a>
            <a href="{{ route('health_records.index') }}">Historial Médico</a>
            <a href="{{ route('medications.index') }}">Medicamentos</a>
            <a href="{{ route('activities.index') }}">Actividades</a>
            <a href="{{ route('visits.index') }}">Visitas</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
