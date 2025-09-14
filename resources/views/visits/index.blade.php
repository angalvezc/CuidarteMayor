@extends('layouts.app1')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Listado de Visitas</h2>
        <a href="{{ route('visits.create') }}" class="btn btn-success">
            Registrar Nueva Visita
        </a>
    </div>

    {{-- 🔍 Formulario de búsqueda --}}
    <form method="GET" action="{{ route('visits.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por documento de residente" value="{{ $search }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
            @if($search)
                <a href="{{ route('visits.index') }}" class="btn btn-secondary">Limpiar</a>
            @endif
        </div>
    </form>

    <div class="table-responsive shadow rounded">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Documento Residente</th>
                    <th>Residente</th>
                    <th>Documento Visitante</th>
                    <th>Visitante</th>
                    <th>Relación</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visits as $visit)
                    <tr>
                        <td>{{ $visit->resident->dni }}</td>
                        <td>{{ $visit->resident->name }}</td>
                        <td>{{ $visit->user->dni }}</td>
                        <td>{{ $visit->user->name }}</td>
                        <td>{{ $visit->relationship }}</td>
                        <td>{{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning btn-sm me-1">Editar</a>
                            <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar esta visita?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No se encontraron visitas para el documento ingresado
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Paginación --}}
    <div class="mt-3">
        {{ $visits->appends(['search' => $search])->links() }}
    </div>
</div>
@endsection
