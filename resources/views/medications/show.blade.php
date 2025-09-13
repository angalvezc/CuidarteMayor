@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle del Medicamento</h2>

    <p><strong>Nombre:</strong> {{ $medication->name }}</p>
    <p><strong>Dosis:</strong> {{ $medication->dosage }}</p>
    <p><strong>Instrucciones:</strong> {{ $medication->instructions }}</p>
    <p><strong>Fecha de administración:</strong> {{ $medication->administration_date }}</p>
    <p><strong>Registrado por:</strong> {{ $medication->user->name ?? 'Desconocido' }}</p>

    <a href="{{ route('medications.index', $medication->health_record_id) }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
