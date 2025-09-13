@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Residentes</h2>
    <a href="{{ route('residents.create') }}" class="btn btn-success mb-3">Crear Residente</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Género</th>
                <th>Estado de Ánimo</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($residents as $resident)
                <tr>
                    <td>{{ $resident->id }}</td>
                    <td>{{ $resident->name }}</td>
                    <td>{{ $resident->birth_date }}</td>
                    <td>{{ $resident->gender }}</td>
                    <td>{{ $resident->mood ?? 'N/A' }}</td>
                    <td>{{ $resident->contactUser->name ?? 'N/A' }}</td>
                    <td>{{ $resident->contactUser?->phone ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('residents.edit', $resident) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('residents.destroy', $resident) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este residente?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No hay residentes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
