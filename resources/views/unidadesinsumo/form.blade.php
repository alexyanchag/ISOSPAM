@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($unidad) ? 'Editar' : 'Nueva' }} Unidad de Insumo</h3>
<form method="POST" action="{{ isset($unidad) ? route('unidadesinsumo.update', $unidad['id']) : route('unidadesinsumo.store') }}">
    @csrf
    @if(isset($unidad))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $unidad['nombre'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Abreviatura</label>
        <input type="text" name="abreviatura" class="form-control" value="{{ old('abreviatura', $unidad['abreviatura'] ?? '') }}">
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('unidadesinsumo.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
