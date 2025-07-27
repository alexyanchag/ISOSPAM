@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipomotor) ? 'Editar' : 'Nuevo' }} Tipo de Motor</h3>
<form method="POST" action="{{ isset($tipomotor) ? route('tipomotores.update', $tipomotor['id']) : route('tipomotores.store') }}">
    @csrf
    @if(isset($tipomotor))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipomotor['nombre'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Motor HP</label>
        <input type="number" step="any" name="motor_hp" class="form-control" value="{{ old('motor_hp', $tipomotor['motor_hp'] ?? '') }}">
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipomotores.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
