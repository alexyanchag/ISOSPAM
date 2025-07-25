@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($embarcacion) ? 'Editar' : 'Nueva' }} Embarcación</h3>
<form method="POST" action="{{ isset($embarcacion) ? route('embarcaciones.update', $embarcacion['id']) : route('embarcaciones.store') }}">
    @csrf
    @if(isset($embarcacion))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $embarcacion['codigo'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $embarcacion['nombre'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Matrícula</label>
        <input type="text" name="matricula" class="form-control" value="{{ old('matricula', $embarcacion['matricula'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo Embarcación</label>
        <select name="tipo_embarcacion_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo['id'] }}" @selected(old('tipo_embarcacion_id', $embarcacion['tipo_embarcacion_id'] ?? '') == $tipo['id'])>
                    {{ $tipo['nombre'] ?? $tipo['descripcion'] ?? $tipo['id'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Eslora</label>
        <input type="number" step="any" name="eslora" class="form-control" value="{{ old('eslora', $embarcacion['eslora'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo Motor ID</label>
        <select name="tipo_motor_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($tiposMotor as $motor)
                <option value="{{ $motor['id'] }}" @selected(old('tipo_motor_id', $embarcacion['tipo_motor_id'] ?? '') == $motor['id'])>
                    {{ $motor['nombre'] ?? $motor['descripcion'] ?? $motor['id'] }}
                </option>
            @endforeach
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('embarcaciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
