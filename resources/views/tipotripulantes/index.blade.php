@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Tipos de Tripulante</h3>
    <a href="{{ route('tipotripulantes.create') }}" class="btn btn-primary">Nuevo</a>
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
            <th>Descripcion</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($tipostripulante as $tipo)
        <tr>
            <td>{{ $tipo['descripcion'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('tipotripulantes.edit', $tipo['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('tipotripulantes.destroy', $tipo['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
