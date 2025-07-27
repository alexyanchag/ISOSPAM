@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($asignacion) ? 'Editar' : 'Nueva' }} Asignación Responsable</h3>
<form method="POST" action="{{ isset($asignacion) ? route('asignacionresponsable.update', $asignacion['id']) : route('asignacionresponsable.store') }}">
    @csrf
    @if(isset($asignacion))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Organización Pesquera</label>
        <select name="organizacion_pesquera_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($organizaciones as $org)
                <option value="{{ $org['id'] }}" @selected(old('organizacion_pesquera_id', $asignacion['organizacion_pesquera_id'] ?? '') == $org['id'])>
                    {{ $org['nombre'] ?? $org['id'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Persona Responsable</label>
        <select name="persona_idpersona" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($personas as $per)
                <option value="{{ $per['idpersona'] }}" @selected(old('persona_idpersona', $asignacion['persona_idpersona'] ?? '') == $per['idpersona'])>
                    {{ $per['nombres'] ?? '' }} {{ $per['apellidos'] ?? '' }} - {{ $per['identificacion'] ?? '' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $asignacion['fecha_inicio'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin', $asignacion['fecha_fin'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Estado</label>
        <input type="text" name="estado" class="form-control" value="{{ old('estado', $asignacion['estado'] ?? '') }}">
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('asignacionresponsable.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
