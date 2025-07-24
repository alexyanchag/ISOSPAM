@extends('layouts.dashboard')

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
</form>
@endsection
