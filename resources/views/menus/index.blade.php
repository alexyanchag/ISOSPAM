@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Menús</h3>
    <a href="{{ route('menus.create') }}" class="btn btn-primary">Nuevo</a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Opción</th>
            <th>Nivel</th>
            <th>Padre</th>
            <th>Activo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($menus as $menu)
        <tr>
            <td>{{ $menu['opcion'] ?? '' }}</td>
            <td>{{ $menu['nivel'] ?? '' }}</td>
            <td>{{ $menu['idmenupadre'] ?? '' }}</td>
            <td>{{ isset($menu['activo']) && $menu['activo'] ? 'Sí' : 'No' }}</td>
            <td class="text-right">
                <a href="{{ route('menus.edit', $menu['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('menus.destroy', $menu['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
