@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Campañas</h3>
    <a href="{{ route('campanias.create') }}" class="btn btn-primary">Nueva</a>
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
            <th>Inicio</th>
            <th>Fin</th>
            <th>Descripción</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($campanias as $campania)
        <tr>
            <td>{{ $campania['fechainicio'] ?? '' }}</td>
            <td>{{ $campania['fechafin'] ?? '' }}</td>
            <td>{{ $campania['descripcion'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('campanias.edit', $campania['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('campanias.destroy', $campania['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
