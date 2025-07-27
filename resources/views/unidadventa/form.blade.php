@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($unidad) ? 'Editar' : 'Nueva' }} Unidad de Venta</h3>
<form method="POST" action="{{ isset($unidad) ? route('unidadventa.update', $unidad['id']) : route('unidadventa.store') }}">
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
    <a href="{{ route('unidadventa.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
