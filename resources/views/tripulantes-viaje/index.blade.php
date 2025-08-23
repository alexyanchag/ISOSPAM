@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Tripulantes</h3>
    @if($viajeId)
        <a href="{{ route('tripulantes-viaje.create', ['viaje_id' => $viajeId]) }}" class="btn btn-primary">Nuevo</a>
    @endif
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
            <th>Tipo</th>
            <th>Persona</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($tripulantes as $t)
        <tr>
            <td>{{ $t['tipo_tripulante_nombre'] ?? '' }}</td>
            <td>{{ $t['tripulante_nombres'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('tripulantes-viaje.edit', $t['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('tripulantes-viaje.destroy', $t['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="viaje_id" value="{{ $viajeId }}">
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
