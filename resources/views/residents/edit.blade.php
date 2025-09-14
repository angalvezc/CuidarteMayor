@extends('layouts.app1')

@section('title', 'Editar Residente')

@section('content')
<div class="container mb-5">
    <h2 class="mb-4">Editar Residente</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('residents.update', $resident->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="dni" class="form-label">DNI / Cédula</label>
                    <input type="text" name="dni" id="dni" class="form-control"
                           value="{{ old('dni', $resident->dni) }}" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name', $resident->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="birth_date" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date"
                           value="{{ old('birth_date', $resident->birth_date ? \Carbon\Carbon::parse($resident->birth_date)->format('Y-m-d') : '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Género</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">Seleccione...</option>
                        <option value="Masculino" {{ old('gender', $resident->gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('gender', $resident->gender) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('gender', $resident->gender) == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="medical_history" class="form-label">Historial Médico</label>
                    <textarea class="form-control" id="medical_history" name="medical_history" rows="4">{{ old('medical_history', $resident->medical_history) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="allergies" class="form-label">Alergias</label>
                    <input type="text" class="form-control" id="allergies" name="allergies"
                           value="{{ old('allergies', $resident->allergies) }}">
                </div>

                <div class="mb-3">
                    <label for="mood" class="form-label">Estado de ánimo</label>
                    <input type="text" class="form-control" id="mood" name="mood"
                           value="{{ old('mood', $resident->mood) }}">
                </div>

                {{-- Campo de DNI del contacto --}}
                <div class="mb-3">
                    <label for="contact_user_dni" class="form-label">DNI / Cédula del contacto</label>
                    <input type="text" class="form-control" id="contact_user_dni" name="contact_user_dni"
                           placeholder="Ingrese el DNI del familiar"
                           value="{{ old('contact_user_dni', $resident->contactUser ? $resident->contactUser->dni : '') }}">
                </div>

                {{-- Input deshabilitado para mostrar nombre del contacto --}}
                <div class="mb-3">
                    <label for="contact_user_name" class="form-label">Nombre del contacto</label>
                    <input type="text" class="form-control" id="contact_user_name" disabled
                           value="{{ old('contact_user_name', $resident->contactUser ? $resident->contactUser->name : '') }}">
                </div>

                {{-- Campo hidden para enviar el ID del contacto --}}
                <input type="hidden" name="contact_user_id" id="contact_user_id"
                       value="{{ old('contact_user_id', $resident->contact_user_id) }}">

                {{-- Tipo de relación --}}
                <div class="mb-3">
                    <label for="contact_relation" class="form-label">Tipo de relación con el contacto</label>
                    <select class="form-select" id="contact_relation" name="contact_relation">
                        <option value="">Seleccione...</option>
                        @php
                            $relation = old('contact_relation', $resident->contact_relation);
                        @endphp
                        <option value="Hijo" {{ $relation == 'Hijo' ? 'selected' : '' }}>Hijo</option>
                        <option value="Hermano" {{ $relation == 'Hermano' ? 'selected' : '' }}>Hermano</option>
                        <option value="Conyugue" {{ $relation == 'Conyugue' ? 'selected' : '' }}>Conyugue</option>
                        <option value="Nieto" {{ $relation == 'Nieto' ? 'selected' : '' }}>Nieto</option>
                        <option value="Otro" {{ $relation == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('residents.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Residente</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS para buscar el nombre del contacto --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('contact_user_dni');
    const nameInput = document.getElementById('contact_user_name');
    const contactIdInput = document.getElementById('contact_user_id');

    function fetchContact(dni) {
        if(dni.length === 0){
            nameInput.value = '';
            contactIdInput.value = '';
            return;
        }

        fetch(`/users/search-by-dni/${dni}`)
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    nameInput.value = data.name;
                    contactIdInput.value = data.id;
                } else {
                    nameInput.value = 'No encontrado';
                    contactIdInput.value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                nameInput.value = '';
                contactIdInput.value = '';
            });
    }

    dniInput.addEventListener('input', function() {
        fetchContact(this.value.trim());
    });

    if(dniInput.value.trim() !== ''){
        fetchContact(dniInput.value.trim());
    }
});
</script>
@endsection
