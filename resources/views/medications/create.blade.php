@extends('layouts.app1')

@section('content')
<div class="container">
    <h2>Registrar Medicamento</h2>

    <form action="{{ route('medications.store') }}" method="POST">
        @csrf

        {{-- Selección del paciente (health_record_id) --}}
        <div class="form-group">
            <label for="health_record_id">Paciente</label>
            <select name="health_record_id" id="health_record_id" class="form-control" required>
                @foreach($healthRecords as $record)
                    <option value="{{ $record->id }}">
                        {{ $record->resident->name }} - {{ $record->resident->document_number }}
                        (Diagnóstico: {{ $record->diagnosis }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nombre del medicamento --}}
        <div class="form-group">
            <label for="name">Nombre del Medicamento</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        {{-- Dosis --}}
        <div class="form-group">
            <label for="dosage">Dosis</label>
            <input type="text" name="dosage" id="dosage" class="form-control">
        </div>

        {{-- Instrucciones --}}
        <div class="form-group">
            <label for="instructions">Instrucciones</label>
            <textarea name="instructions" id="instructions" class="form-control" rows="3"></textarea>
        </div>

        {{-- Fecha de administración --}}
        <div class="form-group">
            <label for="administration_date">Fecha de Administración</label>
            <input type="date" name="administration_date" id="administration_date" class="form-control" required>
        </div>

        {{-- user_id no se pide, se asigna en el controlador con Auth::id() --}}

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('medications.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
