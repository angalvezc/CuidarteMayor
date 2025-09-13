@extends('layouts.app1')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dosis de {{ $record->resident->name }} (DNI: {{ $record->resident->dni }})</h2>

    <a href="{{ route('medications.index') }}" class="btn btn-secondary mb-3">Volver</a>

    {{-- Tabla de dosis registradas --}}
    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Enfermerx</th>
                    <th>Medicamento</th>
                    <th>Dosis</th>
                    <th>Instrucciones</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($record->medications as $med)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $med->user->name ?? 'N/A' }}</td>
                        <td>{{ $med->name }}</td>

                        <td>{{ $med->dosage ?? '-' }}</td>
                        <td>{{ $med->instructions ?? '-' }}</td>
                        <td>{{ $med->administration_date->format('d/m/Y H:i') }}</td>

                        <td>
                            <!-- Botón editar -->
                            <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#editForm{{ $med->id }}">
                                Editar
                            </button>

                            <div class="collapse mt-2" id="editForm{{ $med->id }}">
                                <form action="{{ route('medications.update', $med->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <input type="text" name="dosage" value="{{ $med->dosage }}" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="instructions" class="form-control form-control-sm" rows="2" required>{{ $med->instructions }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm w-100">Actualizar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay dosis registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Formulario para registrar nueva dosis --}}
    <div class="mt-4 shadow p-3 rounded">
        <h5>Registrar nueva dosis</h5>
        <form action="{{ route('medications.store') }}" method="POST">
            @csrf
            <input type="hidden" name="health_record_id" value="{{ $record->id }}">

            <div class="mb-2">
                <input type="text" name="medication_name" class="form-control form-control-sm" placeholder="Nombre del medicamento">
            </div>
            <div class="mb-2">
                <input type="text" name="dosage" class="form-control form-control-sm" placeholder="Dosis" required>
            </div>
            <div class="mb-2">
                <textarea name="instructions" class="form-control form-control-sm" placeholder="Instrucciones" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">Registrar</button>
        </form>
    </div>

</div>
@endsection
