@extends('layouts.app1')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Administración de Medicamentos</h2>

    {{-- Formulario de búsqueda --}}
    <form action="{{ route('medications.index') }}" method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI..." value="{{ request('dni') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('medications.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Género</th>
                    <th>Historial Médico</th>
                    <th>Estado de Ánimo</th>
                    <th>Alergias</th>
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                    <th>Última Dosis</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($residents as $resident)
                @foreach($resident->healthRecords as $record)
                    <tr>
                        <td>{{ $resident->dni }}</td>
                        <td>{{ $resident->name }}</td>
                        <td>{{ $resident->gender }}</td>
                        <td>{{ $resident->medical_history }}</td>
                        <td>{{ $resident->mood }}</td>
                        <td>{{ $resident->allergies }}</td>
                        <td>{{ $record->diagnosis }}</td>
                        <td>{{ $record->treatment }}</td>

                        {{-- Última dosis --}}
                        @php $lastMedication = $record->medications->last(); @endphp
                        <td>
                            @if($lastMedication)
                                <span class="d-block"><strong>Enfermerx:</strong> {{ $lastMedication->nurse->name ?? 'N/A' }}</span>
                                <span class="d-block"><strong>Fecha:</strong> {{ $lastMedication->administration_date->timezone('America/Bogota')->format('Y-m-d H:i') }}</span>


                            @else
                                <em class="text-muted">No administrada</em>
                            @endif
                        </td>

                                                {{-- Acción --}}
                        <td class="text-center">


                            {{-- Botón registrar dosis --}}
                            <a href="{{ route('medications.record', $record->id) }}" class="btn btn-primary btn-sm w-100">
                                Registrar Dosis
                            </a>


                            {{-- Botón completar --}}
                            {{-- <form action="{{ route('medications.complete', $record->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    Completar
                                </button>
                            </form>--}}


                            {{-- Formulario colapsable --}}
                            <div class="collapse mt-2" id="collapseForm{{ $record->id }}">
                                <form action="{{ route('medications.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="health_record_id" value="{{ $record->id }}">

                                    <div class="mb-2">
                                        <input type="text" name="dosage" class="form-control form-control-sm"
                                            placeholder="Dosis" required>
                                    </div>

                                    <div class="mb-2">
                                        <textarea name="instructions" class="form-control form-control-sm"
                                            placeholder="Instrucciones" rows="2" required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        Guardar
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No se encontraron residentes</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
