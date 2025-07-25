@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($materialmalla) ? 'Editar' : 'Nuevo' }} Material de Malla</h3>
<form method="POST" action="{{ isset($materialmalla) ? route('materialesmalla.update', $materialmalla['id']) : route('materialesmalla.store') }}">
    @csrf
    @if(isset($materialmalla))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $materialmalla['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('materialesmalla.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
