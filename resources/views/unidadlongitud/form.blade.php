@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($unidad) ? 'Editar' : 'Nueva' }} Unidad de Longitud</h3>
<form method="POST" action="{{ isset($unidad) ? route('unidadlongitud.update', $unidad['id']) : route('unidadlongitud.store') }}">
    @csrf
    @if(isset($unidad))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $unidad['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('unidadlongitud.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
