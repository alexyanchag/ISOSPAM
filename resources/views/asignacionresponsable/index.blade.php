@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Asignaciones de Responsable @if($organizacion) de {{ $organizacion['nombre'] ?? '' }} @endif</h3>
    <a href="{{ route('asignacionresponsable.create', $organizacionId ? ['organizacion_pesquera_id' => $organizacionId] : []) }}" class="btn btn-primary">Nueva</a>
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
            <th>Organización</th>
            <th>Responsable</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($asignaciones as $asignacion)
        <tr>
            <td>{{ $asignacion['organizacion_nombre'] ?? '' }}</td>
            <td>{{ ($asignacion['nombres'] ?? '') . ' ' . ($asignacion['apellidos'] ?? '') }}</td>
            <td>{{ $asignacion['fecha_inicio'] ?? '' }}</td>
            <td>{{ $asignacion['fecha_fin'] ?? '' }}</td>
            <td>{{ $asignacion['estado'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('asignacionresponsable.edit', $asignacion['id']) }}{{ $organizacionId ? '?organizacion_pesquera_id='.$organizacionId : '' }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('asignacionresponsable.destroy', $asignacion['id']) }}{{ $organizacionId ? '?organizacion_pesquera_id='.$organizacionId : '' }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($organizacionId)
    <a href="{{ route('organizacionpesquera.index') }}" class="btn btn-secondary mt-2">Volver a Organizaciones</a>
@endif
@endsection
