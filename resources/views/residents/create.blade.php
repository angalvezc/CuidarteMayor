@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Residente</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('residents.store') }}" method="POST">
        @csrf
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

        <div class="mb-3">
            <label for="contact_user_id" class="form-label">Contacto (Usuario)</label>
            <select class="form-select" id="contact_user_id" name="contact_user_id">
                <option value="">Ninguno</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('residents.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
