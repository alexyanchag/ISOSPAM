@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipoarte) ? 'Editar' : 'Nuevo' }} Tipo de Arte</h3>
<form method="POST" action="{{ isset($tipoarte) ? route('tipoartes.update', $tipoarte['id']) : route('tipoartes.store') }}">
    @csrf
    @if(isset($tipoarte))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipoarte['nombre'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo</label>
        <input type="text" name="tipo" class="form-control" value="{{ old('tipo', $tipoarte['tipo'] ?? '') }}">
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipoartes.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
