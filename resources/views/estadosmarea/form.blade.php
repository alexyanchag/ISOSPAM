@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($estado) ? 'Editar' : 'Nuevo' }} Estado de Marea</h3>
<form method="POST" action="{{ isset($estado) ? route('estadosmarea.update', $estado['id']) : route('estadosmarea.store') }}">
    @csrf
    @if(isset($estado))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $estado['descripcion'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('estadosmarea.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
