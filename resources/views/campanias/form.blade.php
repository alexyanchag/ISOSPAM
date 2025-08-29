@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($campania) ? 'Editar' : 'Nueva' }} Campaña</h3>
<form method="POST" action="{{ isset($campania) ? route('campanias.update', $campania['id']) : route('campanias.store') }}">
    @csrf
    @if(isset($campania))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Fecha Inicio</label>
        <input type="date" name="fechainicio" class="form-control" value="{{ old('fechainicio', $campania['fechainicio'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Fecha Fin</label>
        <input type="date" name="fechafin" class="form-control" value="{{ old('fechafin', $campania['fechafin'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $campania['descripcion'] ?? '') }}">
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('campanias.index') }}" class="btn btn-secondary">Cancelar</a>
    @if(isset($campania))
        <a href="{{ route('campanias.tabla-multifinalitaria.index', $campania['id']) }}" class="btn btn-info">Tabla Multifinalitaria</a>
    @endif
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const fechainicio = form.querySelector('input[name="fechainicio"]');
    const fechafin = form.querySelector('input[name="fechafin"]');

    function updateLimits() {
        if (fechainicio.value) {
            fechafin.min = fechainicio.value;
        }
        if (fechafin.value) {
            fechainicio.max = fechafin.value;
        }
    }

    fechainicio.addEventListener('change', function () {
        updateLimits();
        if (fechafin.value && fechainicio.value > fechafin.value) {
            alert('La fecha de inicio no puede ser mayor a la fecha fin.');
            fechainicio.value = '';
        }
    });

    fechafin.addEventListener('change', function () {
        updateLimits();
        if (fechainicio.value && fechafin.value < fechainicio.value) {
            alert('La fecha fin no puede ser menor a la fecha inicio.');
            fechafin.value = '';
        }
    });

    form.addEventListener('submit', function (e) {
        if (fechainicio.value && fechafin.value && fechainicio.value > fechafin.value) {
            e.preventDefault();
            alert('La fecha de inicio no puede ser mayor a la fecha fin.');
        }
    });

    updateLimits();
});
</script>
@endsection
