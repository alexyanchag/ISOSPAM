@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($condicion) ? 'Editar' : 'Nueva' }} Condición del Mar</h3>
<form method="POST" action="{{ isset($condicion) ? route('condicionesmar.update', $condicion['id']) : route('condicionesmar.store') }}">
    @csrf
    @if(isset($condicion))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $condicion['descripcion'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('condicionesmar.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
