@extends('layouts.app1')

@section('content')
<div class="container">
    <h2>Editar Visita</h2>

    <form action="{{ route('visits.update', $visit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Buscar Residente por DNI -->
        <div class="mb-3">
            <label for="dni_resident" class="form-label">Documento Residente</label>
            <input type="text" id="dni_resident" class="form-control" placeholder="Ingrese Documento del residente">
            <button type="button" class="btn btn-primary mt-2" id="searchResident">Buscar</button>
            <input type="hidden" name="resident_id" id="resident_id" value="{{ $visit->resident_id }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre Residente</label>
            <input type="text" id="resident_name" class="form-control" value="{{ $visit->resident->name }}" disabled>
        </div>

        <!-- Buscar Visitante por DNI -->
        <div class="mb-3">
            <label for="dni_user" class="form-label">Documento Visitante</label>
            <input type="text" id="dni_user" class="form-control" placeholder="Ingrese Documento del visitante">
            <button type="button" class="btn btn-primary mt-2" id="searchUser">Buscar</button>
            <input type="hidden" name="user_id" id="user_id" value="{{ $visit->user_id }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre Visitante</label>
            <input type="text" id="user_name" class="form-control" value="{{ $visit->user->name }}" disabled>
        </div>

        <!-- Fecha y Hora -->
        <div class="mb-3">
            <label for="visit_date" class="form-label">Fecha de la visita</label>
            <input type="date" name="visit_date" class="form-control" value="{{ $visit->visit_date }}" required>
        </div>

        <div class="mb-3">
            <label for="visit_time" class="form-label">Hora de la visita</label>
            <input type="time" name="visit_time" class="form-control" value="{{ $visit->visit_time }}" required>
        </div>

        <!-- Relación -->
        <div class="mb-3">
            <label for="relationship" class="form-label">Relación</label>
            <input type="text" name="relationship" class="form-control" value="{{ $visit->relationship }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar Visita</button>
        <a href="{{ route('visits.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Buscar residente por DNI
    $('#searchResident').click(function () {
        let dni = $('#dni_resident').val();
        $.ajax({
            url: "{{ route('visits.findResident') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                dni: dni
            },
            success: function (response) {
                if (response.success) {
                    $('#resident_name').val(response.name);
                    $('#resident_id').val(response.id);
                } else {
                    alert('Residente no encontrado');
                }
            }
        });
    });

    // Buscar visitante (user) por DNI
    $('#searchUser').click(function () {
        let dni = $('#dni_user').val();
        $.ajax({
            url: "{{ route('visits.findUser') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                dni: dni
            },
            success: function (response) {
                if (response.success) {
                    $('#user_name').val(response.name);
                    $('#user_id').val(response.id);
                } else {
                    alert('Visitante no encontrado');
                }
            }
        });
    });
</script>
@endsection
