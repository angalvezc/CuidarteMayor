@extends('layouts.app1')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Lista de Residentes</h2>
        <a href="{{ route('residents.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-person-plus"></i> Crear Residente
        </a>
    </div>

    {{-- Formulario de búsqueda por DNI --}}
    <form action="{{ route('residents.index') }}" method="GET" class="mb-3 shadow-sm p-3 rounded bg-light">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI..." value="{{ request('dni') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <a href="{{ route('residents.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            </div>
        </div>
    </form>

    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th># Identificación</th>
                    <th>Nombre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Género</th>
                    <th>Estado de Ánimo</th>
                    <th>Contacto</th>
                    <th>Relación</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($residents as $resident)
                <tr class="text-center">
                    <td>{{ $resident->id }}</td>
                    <td>{{ $resident->dni }}</td>
                    <td class="text-start">{{ $resident->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($resident->birth_date)->format('d/m/Y') }}</td>
                    <td>{{ $resident->gender }}</td>
                    <td>{{ $resident->mood ?? 'N/A' }}</td>
                    <td>{{ $resident->contactUser->name ?? 'N/A' }}</td>
                    <td>{{ $resident->contact_relation ?? 'N/A' }}</td>
                    <td>{{ $resident->contactUser?->phone ?? 'N/A' }}</td>
                    <td class="text-center">
                        <a href="{{ route('residents.edit', $resident) }}" class="btn btn-primary btn-sm mb-1">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <form action="{{ route('residents.destroy', $resident) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este residente?')">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-3">No hay residentes registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
