@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($estado) ? 'Editar' : 'Nuevo' }} Estado de Desarrollo Gonadal</h3>
<form method="POST" action="{{ isset($estado) ? route('estadodesarrollogonadal.update', $estado['id']) : route('estadodesarrollogonadal.store') }}">
    @csrf
    @if(isset($estado))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $estado['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('estadodesarrollogonadal.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
