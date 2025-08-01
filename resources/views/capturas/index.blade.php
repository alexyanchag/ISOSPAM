@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Capturas</h3>
    @if($viajeId)
        <a href="{{ route('capturas.create', ['viaje_id' => $viajeId]) }}" class="btn btn-primary">Nueva</a>
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
            <th>Nombre común</th>
            <th>Nº Individuos</th>
            <th>Peso Estimado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($capturas as $c)
        <tr>
            <td>{{ $c['nombre_comun'] ?? '' }}</td>
            <td>{{ $c['numero_individuos'] ?? '' }}</td>
            <td>{{ $c['peso_estimado'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('capturas.edit', $c['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('capturas.destroy', $c['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
