@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($muelle) ? 'Editar' : 'Nuevo' }} Muelle</h3>
<form method="POST" action="{{ isset($muelle) ? route('muelles.update', $muelle['id']) : route('muelles.store') }}">
    @csrf
    @if(isset($muelle))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $muelle['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('muelles.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
