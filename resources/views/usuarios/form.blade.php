@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<h3>{{ isset($usuario) ? 'Editar' : 'Nuevo' }} Usuario</h3>
<form method="POST" action="{{ isset($usuario) ? route('usuarios.update', $usuario->idpersona) : route('usuarios.store') }}">
    @csrf
    @if(isset($usuario))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Identificación</label>
        <input type="text" name="identificacion" class="form-control" value="{{ old('identificacion', $persona->identificacion ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nombres</label>
        <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $persona->nombres ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Apellidos</label>
        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $persona->apellidos ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $persona->direccion ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Celular</label>
        <input type="text" name="celular" class="form-control" value="{{ old('celular', $persona->celular ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $persona->email ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input type="text" name="usuario" class="form-control" value="{{ old('usuario', $usuario->usuario ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Clave</label>
        <input type="text" name="clave" class="form-control" value="{{ old('clave', $usuario->clave ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Activo</label>
        <select name="activo" class="form-control">
            <option value="1" @selected(old('activo', $usuario->activo ?? 1)==1)>Sí</option>
            <option value="0" @selected(old('activo', $usuario->activo ?? 1)==0)>No</option>
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
