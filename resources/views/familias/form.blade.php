@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($familia) ? 'Editar' : 'Nueva' }} Familia</h3>
<form method="POST" action="{{ isset($familia) ? route('familias.update', $familia['id']) : route('familias.store') }}">
    @csrf
    @if(isset($familia))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $familia['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('familias.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
