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

        {{-- Campo oculto para enviar resident_id --}}
        <input type="hidden" name="resident_id" id="resident_id" required>

        {{-- Campo oculto para asignar el doctor logueado automáticamente --}}
        <input type="hidden" name="doctor_id" value="{{ Auth::id() }}">

        <div class="mb-3">
            <label for="diagnosis" class="form-label">Diagnóstico</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="treatment" class="form-label">Tratamiento</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3"></textarea>
        </div>


        {{-- Campo oculto opcional --}}
        <input type="hidden" name="record_date" value="{{ now() }}">




        <button type="submit" class="btn btn-success" id="submitBtn" disabled>Guardar</button>
        <a href="{{ route('health_records.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- Script AJAX para obtener residente por DNI --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('dni');
    const residentNameInput = document.getElementById('resident_name');
    const residentIdInput = document.getElementById('resident_id');
    const submitBtn = document.getElementById('submitBtn');

    dniInput.addEventListener('blur', function() {
        const dni = this.value.trim();
        if (!dni) return;

        fetch(`/residents/search/${dni}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    residentNameInput.value = data.resident.name;
                    residentIdInput.value = data.resident.id;

                    fetch(`/health-records/check/${data.resident.id}`)
                        .then(res => res.json())
                        .then(checkData => {
                            if (checkData.exists) {
                                alert('Este residente ya tiene un historial médico registrado. No se puede crear otro.');
                                submitBtn.disabled = true;
                                submitBtn.textContent = 'Ya Registrado';
                            } else {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Guardar';
                            }
                        });
                } else {
                    alert('No se encontró un residente con ese DNI');
                    residentNameInput.value = '';
                    residentIdInput.value = '';
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Guardar';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                residentNameInput.value = '';
                residentIdInput.value = '';
                submitBtn.disabled = true;
            });
    });

    document.getElementById('healthForm').addEventListener('submit', function(e) {
        if (!residentIdInput.value) {
            e.preventDefault();
            alert('Por favor ingrese un DNI válido y seleccione un residente.');
        }
    });
});
</script>
@endsection
