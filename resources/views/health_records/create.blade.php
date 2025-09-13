@extends('layouts.app1')

@section('title', 'Registrar Historial Médico')

@section('content')
<div class="container mt-4">
    <h2>Registrar Nuevo Historial Médico</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('health_records.store') }}" method="POST" id="healthForm">
        @csrf

        {{-- Buscar residente por DNI --}}
        <div class="mb-3">
            <label for="dni" class="form-label">DNI del Residente</label>
            <input type="text" id="dni" name="dni" class="form-control" placeholder="Ingrese DNI del residente" required>
        </div>

        <div class="mb-3">
            <label for="resident_name" class="form-label">Nombre del Residente</label>
            <input type="text" id="resident_name" class="form-control" disabled>
        </div>

        {{-- Campo oculto --}}
        <input type="hidden" name="resident_id" id="resident_id">

        {{-- Resto de campos... (doctor_id, diagnosis, treatment, record_date) --}}
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnóstico</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="treatment" class="form-label">Tratamiento</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="record_date" class="form-label">Fecha de Registro</label>
            <input type="date" name="record_date" id="record_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-success" id="submitBtn">Guardar</button>
        <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- Script AJAX mejorado --}}
<script>
document.getElementById('dni').addEventListener('blur', function() {
    let dni = this.value;
    if (dni) {
        fetch(`/residents/search/${dni}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('resident_name').value = data.resident.name;
                    document.getElementById('resident_id').value = data.resident.id;

                    // Verificar si ya existe historial
                    fetch(`/health-records/check/${data.resident.id}`)
                        .then(res => res.json())
                        .then(checkData => {
                            if (checkData.exists) {
                                alert('Este residente ya tiene un historial médico registrado. No se puede crear otro.');
                                document.getElementById('submitBtn').disabled = true;
                                document.getElementById('submitBtn').textContent = 'Ya Registrado';
                            } else {
                                document.getElementById('submitBtn').disabled = false;
                                document.getElementById('submitBtn').textContent = 'Guardar';
                            }
                        });
                } else {
                    alert('No se encontró un residente con ese DNI');
                    document.getElementById('resident_name').value = '';
                    document.getElementById('resident_id').value = '';
                    document.getElementById('submitBtn').disabled = true;
                }
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>
@endsection
