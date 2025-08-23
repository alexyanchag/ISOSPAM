@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($puerto) ? 'Editar' : 'Nuevo' }} Puerto</h3>
<form method="POST" action="{{ isset($puerto) ? route('puertos.update', $puerto['id']) : route('puertos.store') }}">
    @csrf
    @if(isset($puerto))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $puerto['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('puertos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
