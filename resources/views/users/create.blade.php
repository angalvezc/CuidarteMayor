@extends('layouts.app1')

@section('title', 'Crear Usuario')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Usuario</h2>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="dni" class="form-label">Documento de usuario</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="role_id" class="form-label">Rol</label>
                    <select name="role_id" id="role_id" class="form-select" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
