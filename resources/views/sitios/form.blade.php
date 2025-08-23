@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($sitio) ? 'Editar' : 'Nuevo' }} Sitio</h3>
<form method="POST" action="{{ isset($sitio) ? route('sitios.update', $sitio['id']) : route('sitios.store') }}">
    @csrf
    @if(isset($sitio))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $sitio['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('sitios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
