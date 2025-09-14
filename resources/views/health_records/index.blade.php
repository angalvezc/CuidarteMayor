@extends('layouts.app1')

@section('title', 'Historial Médico')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Historial Médico</h2>
        <a href="{{ route('health_records.create') }}" class="btn btn-primary">Registrar Nuevo</a>
    </div>

    {{-- Formulario de búsqueda por DNI --}}
    <form action="{{ route('health_records.index') }}" method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI" value="{{ request('dni') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark">Buscar</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Residente</th>
                <th>DNI</th>
                <th>Doctor</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->resident->name }}</td>
                    <td>{{ $record->resident->dni }}</td>
                    <td>{{ $record->doctor->name }}</td>
                    <td>{{ Str::limit($record->diagnosis, 50) }}</td>
                    <td>{{ Str::limit($record->treatment, 50) }}</td>
                    <td>{{ $record->record_date }}</td>
                    <td>
                        <a href="{{ route('health_records.edit', $record->id) }}" class="btn btn-warning btn-sm">Actualizar</a>

                        {{-- Solo admin puede eliminar --}}
                        @if(auth()->user()->role->name === 'admin')
                            <form action="{{ route('health_records.destroy', $record->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar este registro?')">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
