@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Viajes</h3>
    <a href="{{ route('viajes.create') }}" class="btn btn-primary">Nuevo</a>
</div>
<form method="GET" action="{{ route('viajes.index') }}" class="mb-3">
    <div class="form-row">
        <div class="col">
            <input type="date" name="fecha_inicio" class="form-control" value="{{ $fechaInicio }}">
        </div>
        <div class="col">
            <input type="date" name="fecha_fin" class="form-control" value="{{ $fechaFin }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-secondary">Filtrar</button>
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
            <th>Fecha Zarpe</th>
            <th>Hora Zarpe</th>
            <th>Fecha Arribo</th>
            <th>Hora Arribo</th>
            <th>Embarcación</th>
            <th>Campaña</th>
            <th>Responsable</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($viajes as $v)
        <tr>
            <td>{{ $v['fecha_zarpe'] ?? '' }}</td>
            <td>{{ $v['hora_zarpe'] ?? '' }}</td>
            <td>{{ $v['fecha_arribo'] ?? '' }}</td>
            <td>{{ $v['hora_arribo'] ?? '' }}</td>
            <td>{{ $v['embarcacion_nombre'] ?? '' }}</td>
            <td>{{ $v['campania_descripcion'] ?? '' }}</td>
            <td>{{ ($v['pescador_nombres'] ?? '') . ' ' . ($v['pescador_apellidos'] ?? '') }}</td>
            <td class="text-right">
                <a href="{{ route('viajes.edit', $v['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('viajes.destroy', $v['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
