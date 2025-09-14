@extends('layouts.app1')

@section('title', 'Editar Historial Médico')

@section('content')
<div class="container mt-4">
    <h2>Editar Historial Médico</h2>

    <form action="{{ route('health_records.update', $healthRecord->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Residente (disabled, pero se puede editar alergias) --}}
        <div class="mb-3">
            <label for="resident_name" class="form-label">Residente</label>
            <input type="text" class="form-control" value="{{ $healthRecord->resident->name }}" disabled>
            <input type="hidden" name="resident_id" value="{{ $healthRecord->resident_id }}">
        </div>



        {{-- Doctor (disabled, muestra quien creó el registro) --}}
        <div class="mb-3">
            <label for="doctor_name" class="form-label">Doctor</label>
            <input type="text" class="form-control" value="{{ $healthRecord->doctor->name }}" disabled>
            <input type="hidden" name="doctor_id" value="{{ $healthRecord->doctor_id }}">
        </div>
         <div class="mb-3">
            <label for="alergies" class="form-label">Alergias</label>
            <input type="text" name="alergies" id="alergies" class="form-control" value="{{ old('alergies', $healthRecord->resident->allergies) }}">
        </div>
        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnóstico</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required>{{ old('diagnosis', $healthRecord->diagnosis) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="treatment" class="form-label">Tratamiento</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3">{{ old('treatment', $healthRecord->treatment) }}</textarea>
        </div>

        {{-- Campo oculto opcional --}}
        <input type="hidden" name="record_date" value="{{ now() }}">

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
