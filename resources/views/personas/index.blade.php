@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Personas</h3>
    <a href="{{ route('personas.create') }}" class="btn btn-primary">Nueva</a>
</div>
<form method="GET" action="{{ route('personas.index') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="filtro" class="form-control" placeholder="Buscar" value="{{ $filtro }}">
        <div class="input-group-append">
            <button class="btn btn-secondary">Buscar</button>
        </div>
    </div>
</form>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Identificación</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Celular</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        <tr>
            <td>{{ $persona['identificacion'] ?? '' }}</td>
            <td>{{ $persona['nombres'] ?? '' }}</td>
            <td>{{ $persona['apellidos'] ?? '' }}</td>
            <td>{{ $persona['celular'] ?? '' }}</td>
            <td>{{ $persona['email'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('personas.edit', $persona['idpersona']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('personas.destroy', $persona['idpersona']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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

