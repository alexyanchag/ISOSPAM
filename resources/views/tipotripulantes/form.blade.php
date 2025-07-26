@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipotripulante) ? 'Editar' : 'Nuevo' }} Tipo de Tripulante</h3>
<form method="POST" action="{{ isset($tipotripulante) ? route('tipotripulantes.update', $tipotripulante['id']) : route('tipotripulantes.store') }}">
    @csrf
    @if(isset($tipotripulante))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Descripcion</label>
        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $tipotripulante['descripcion'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipotripulantes.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
