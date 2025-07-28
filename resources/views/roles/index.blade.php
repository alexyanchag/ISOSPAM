@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Roles</h3>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Nuevo</a>
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
            <th>Nombre</th>
            <th>Código</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($roles as $rol)
        <tr>
            <td>{{ $rol['nombrerol'] ?? '' }}</td>
            <td>{{ $rol['codigo'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('roles.edit', $rol['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('roles.destroy', $rol['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
