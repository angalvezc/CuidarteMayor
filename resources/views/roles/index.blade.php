@extends('layouts.app1')

@section('content')
<div class="container">
    <h2>Lista de Roles</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">Crear Rol</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este rol?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No hay roles creados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
