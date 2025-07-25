@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipoanzuelo) ? 'Editar' : 'Nuevo' }} Tipo de Anzuelo</h3>
<form method="POST" action="{{ isset($tipoanzuelo) ? route('tipoanzuelos.update', $tipoanzuelo['id']) : route('tipoanzuelos.store') }}">
    @csrf
    @if(isset($tipoanzuelo))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipoanzuelo['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipoanzuelos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
