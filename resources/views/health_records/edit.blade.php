@extends('layouts.app1')

@section('title', 'Editar Historial Médico')

@section('content')
<div class="container mt-4">
    <h2>Editar Historial Médico</h2>

    <form action="{{ route('health_records.update', $healthRecord->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="resident_id" class="form-label">Residente</label>
            <select name="resident_id" id="resident_id" class="form-select" disabled>
                @foreach($residents as $resident)
                    <option value="{{ $resident->id }}" {{ $resident->id == $healthRecord->resident_id ? 'selected' : '' }}>
                        {{ $resident->name }}
                    </option>
                @endforeach
            </select>
            {{-- Campo oculto para enviar el valor al backend --}}
            <input type="hidden" name="resident_id" value="{{ $healthRecord->resident_id }}">
        </div>


        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $doctor->id == $healthRecord->doctor_id ? 'selected' : '' }}>
                        {{ $doctor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnóstico</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required>{{ $healthRecord->diagnosis }}</textarea>
        </div>

        <div class="mb-3">
            <label for="treatment" class="form-label">Tratamiento</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3">{{ $healthRecord->treatment }}</textarea>
        </div>

        <div class="mb-3">
            <label for="record_date" class="form-label">Fecha de Registro</label>
            <input type="date" name="record_date" id="record_date" class="form-control" value="{{ $healthRecord->record_date }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
