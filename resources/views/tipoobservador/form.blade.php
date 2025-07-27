@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipoobservador) ? 'Editar' : 'Nuevo' }} Tipo de Observador</h3>
<form method="POST" action="{{ isset($tipoobservador) ? route('tipoobservador.update', $tipoobservador['id']) : route('tipoobservador.store') }}">
    @csrf
    @if(isset($tipoobservador))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $tipoobservador['descripcion'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipoobservador.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
