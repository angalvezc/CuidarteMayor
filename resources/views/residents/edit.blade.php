{{-- resources/views/residents/edit.blade.php --}}
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
                    <input type="text" name="dni" id="dni" class="form-control" value="{{ $resident->dni }}" required>
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

                <div class="mb-3">
                    <label for="contact_user_id" class="form-label">Contacto (Usuario)</label>
                    <select class="form-select" id="contact_user_id" name="contact_user_id">
                        <option value="">Ninguno</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ (string) old('contact_user_id', $resident->contact_user_id) === (string) $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
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
@endsection
