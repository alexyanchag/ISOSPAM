@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipoembarcacion) ? 'Editar' : 'Nuevo' }} Tipo de Embarcación</h3>
<form method="POST" action="{{ isset($tipoembarcacion) ? route('tipoembarcaciones.update', $tipoembarcacion['id']) : route('tipoembarcaciones.store') }}">
    @csrf
    @if(isset($tipoembarcacion))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipoembarcacion['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipoembarcaciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
