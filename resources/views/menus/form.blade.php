@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($menu) ? 'Editar' : 'Nuevo' }} Menú</h3>
<form method="POST" action="{{ isset($menu) ? route('menus.update', $menu['id']) : route('menus.store') }}">
    @csrf
    @if(isset($menu))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Opción</label>
        <input type="text" name="opcion" class="form-control" value="{{ old('opcion', $menu['opcion'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">URL</label>
        <input type="text" name="url" class="form-control" value="{{ old('url', $menu['url'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nivel</label>
        <input type="text" name="nivel" class="form-control" value="{{ old('nivel', $menu['nivel'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Icono</label>
        <input type="text" name="icono" class="form-control" value="{{ old('icono', $menu['icono'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">URL 2</label>
        <input type="text" name="url2" class="form-control" value="{{ old('url2', $menu['url2'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Icono 2</label>
        <input type="text" name="icono2" class="form-control" value="{{ old('icono2', $menu['icono2'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Menú Padre</label>
        <select name="idmenupadre" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($menus as $m)
                <option value="{{ $m['id'] }}" @selected(old('idmenupadre', $menu['idmenupadre'] ?? '') == $m['id'])>{{ $m['opcion'] ?? $m['id'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3 form-check">
        <input type="hidden" name="activo" value="0">
        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $menu['activo'] ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="activo">Activo</label>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
