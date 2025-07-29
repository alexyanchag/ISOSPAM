@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title mb-0">{{ isset($persona) ? 'Editar' : 'Nueva' }} Persona</h3>
    </div>
    <form method="POST" action="{{ isset($persona) ? route('personas.update', $persona['idpersona']) : route('personas.store') }}">
        @csrf
        @if(isset($persona))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Identificación</label>
                <input type="text" name="identificacion" class="form-control" value="{{ old('identificacion', $persona['identificacion'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $persona['nombres'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $persona['apellidos'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $persona['direccion'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Celular</label>
                <input type="text" name="celular" class="form-control" value="{{ old('celular', $persona['celular'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $persona['email'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Estado Civil</label>
                <input type="number" name="estadocivil" class="form-control" value="{{ old('estadocivil', $persona['estadocivil'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fechanacimiento" class="form-control" value="{{ old('fechanacimiento', $persona['fechanacimiento'] ?? '') }}">
            </div>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

