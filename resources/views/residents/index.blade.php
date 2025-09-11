@extends('layouts.app')

@section('title', 'Residentes')

@section('content')
    <h2>Lista de Residentes</h2>
    <a href="{{ route('residents.create') }}">Agregar Nuevo Residente</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Género</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($residents as $resident)
                <tr>
                    <td>{{ $resident->name }}</td>
                    <td>{{ $resident->birth_date }}</td>
                    <td>{{ $resident->gender }}</td>
                    <td>{{ $resident->contactUser?->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('residents.edit', $resident->id) }}">Editar</a>
                        <form action="{{ route('residents.destroy', $resident->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
