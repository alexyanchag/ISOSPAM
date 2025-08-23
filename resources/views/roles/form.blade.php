@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($rol) ? 'Editar' : 'Nuevo' }} Rol</h3>
<form method="POST" action="{{ isset($rol) ? route('roles.update', $rol['id']) : route('roles.store') }}">
    @csrf
    @if(isset($rol))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombrerol" class="form-control" value="{{ old('nombrerol', $rol['nombrerol'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $rol['codigo'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
