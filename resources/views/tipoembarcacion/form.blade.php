@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($tipoembarcacion) ? 'Editar' : 'Nuevo' }} Tipo de Embarcación</h3>
<form method="POST" action="{{ isset($tipoembarcacion) ? route('tipoembarcaciones.update', $tipoembarcacion['id']) : route('tipoembarcaciones.store') }}">
    @csrf
    @if(isset($tipoembarcacion))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipoembarcacion['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipoembarcaciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@isset($tipoembarcacion)
    <hr>
    <div class="d-flex justify-content-between mb-2">
        <h4>Embarcaciones</h4>
        <a href="{{ route('embarcaciones.create') }}" class="btn btn-sm btn-primary">Nueva</a>
    </div>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Matrícula</th>
                <th>Eslora</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($embarcaciones ?? [] as $emb)
            <tr>
                <td>{{ $emb['codigo'] ?? '' }}</td>
                <td>{{ $emb['nombre'] ?? '' }}</td>
                <td>{{ $emb['matricula'] ?? '' }}</td>
                <td>{{ $emb['eslora'] ?? '' }}</td>
                <td class="text-right">
                    <a href="{{ route('embarcaciones.edit', $emb['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form action="{{ route('embarcaciones.destroy', $emb['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Sin embarcaciones registradas</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endisset
@endsection
