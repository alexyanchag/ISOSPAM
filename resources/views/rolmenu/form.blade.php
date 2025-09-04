@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ isset($item) ? 'Editar' : 'Nueva' }} Asignación Menú a Rol</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($item) ? route('rolmenu.update', ['idrol' => $item['idrol'], 'idmenu' => $item['idmenu']]) : route('rolmenu.store') }}">
            @csrf
            @if(isset($item))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="idrol" class="form-control" {{ isset($item) ? 'disabled' : '' }} required>
                    <option value="">Seleccione...</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol['id'] }}" @selected(old('idrol', $item['idrol'] ?? $rolMenuId ?? '') == $rol['id'])>{{ $rol['nombrerol'] ?? $rol['id'] }}</option>
                    @endforeach
                </select>
                @if(isset($item))
                    <input type="hidden" name="idrol" value="{{ $item['idrol'] }}">
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Menú</label>
                <select name="idmenu" class="form-control" {{ isset($item) ? 'disabled' : '' }} required>
                    <option value="">Seleccione...</option>
                    @foreach($menus as $m)
                        <option value="{{ $m['id'] }}" @selected(old('idmenu', $item['idmenu'] ?? '') == $m['id'])>{{ $m['opcion'] ?? $m['id'] }}</option>
                    @endforeach
                </select>
                @if(isset($item))
                    <input type="hidden" name="idmenu" value="{{ $item['idmenu'] }}">
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Acceso</label>
                <input type="number" name="acceso" class="form-control" value="{{ old('acceso', $item['acceso'] ?? 0) }}" required>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('rolmenu.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
