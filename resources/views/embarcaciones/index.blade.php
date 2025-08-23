@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Embarcaciones</h3>
    <a href="{{ route('embarcaciones.create') }}" class="btn btn-primary">Nueva</a>
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
            <th>Código</th>
            <th>Nombre</th>
            <th>Matrícula</th>
            <th>Eslora</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($embarcaciones as $emb)
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
    @endforeach
    </tbody>
</table>
@endsection
