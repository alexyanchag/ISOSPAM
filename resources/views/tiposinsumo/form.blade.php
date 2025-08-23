@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($insumo) ? 'Editar' : 'Nuevo' }} Tipo de Insumo</h3>
<form method="POST" action="{{ isset($insumo) ? route('tiposinsumo.update', $insumo['id']) : route('tiposinsumo.store') }}">
    @csrf
    @if(isset($insumo))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $insumo['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tiposinsumo.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
