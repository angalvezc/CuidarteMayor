@extends('layouts.app1')

@section('content')
<div class="container">
    <h2>Crear Residente</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('residents.store') }}" method="POST" id="createResidentForm">
        @csrf
        <div class="mb-3">
            <label for="dni" class="form-label">DNI / Cédula</label>
            <input type="text" name="dni" id="dni" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Género</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">Seleccione...</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="medical_history" class="form-label">Historial Médico</label>
            <textarea class="form-control" id="medical_history" name="medical_history"></textarea>
        </div>

        <div class="mb-3">
            <label for="allergies" class="form-label">Alergias</label>
            <input type="text" class="form-control" id="allergies" name="allergies">
        </div>

        <div class="mb-3">
            <label for="mood" class="form-label">Estado de ánimo</label>
            <input type="text" class="form-control" id="mood" name="mood">
        </div>

        {{-- NUEVO: Campo de DNI para Contacto --}}
        {{-- Campo de DNI para Contacto --}}
        <div class="mb-3">
            <label for="contact_user_dni" class="form-label">DNI / Cédula del contacto</label>
            <input type="text" class="form-control" id="contact_user_dni" name="contact_user_dni"
                placeholder="Ingrese el DNI del familiar"
                value="{{ old('contact_user_dni') }}">
        </div>

        {{-- Input deshabilitado para mostrar nombre del contacto --}}
        <div class="mb-3">
            <label for="contact_user_name" class="form-label">Nombre del contacto</label>
            <input type="text" class="form-control" id="contact_user_name" disabled>
        </div>

        {{-- Tipo de relación --}}
        <div class="mb-3">
            <label for="contact_relation" class="form-label">Tipo de relación con el contacto</label>
            <select class="form-select" id="contact_relation" name="contact_relation">
                <option value="">Seleccione...</option>
                <option value="Hijo">Hijo</option>
                <option value="Hermano">Hermano</option>
                <option value="Conyugue">Conyugue</option>
                <option value="Nieto">Nieto</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('residents.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- JS para buscar el nombre del contacto --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('contact_user_dni');
    const nameInput = document.getElementById('contact_user_name');

    function fetchContactName(dni) {
        if(dni.length === 0){
            nameInput.value = '';
            return;
        }

        fetch(`/users/search-by-dni/${dni}`)
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    nameInput.value = data.name;
                } else {
                    nameInput.value = 'No encontrado';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                nameInput.value = '';
            });
    }

    // Buscar nombre al escribir en el input
    dniInput.addEventListener('input', function() {
        fetchContactName(this.value.trim());
    });

    // Si ya hay un valor al cargar la página
    if(dniInput.value.trim() !== ''){
        fetchContactName(dniInput.value.trim());
    }
});
</script>

@endsection
