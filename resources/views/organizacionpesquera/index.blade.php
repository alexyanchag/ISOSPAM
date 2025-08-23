@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Organizaciones Pesqueras</h3>
    <a href="{{ route('organizacionpesquera.create') }}" class="btn btn-primary">Nueva</a>
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
            <th>Zona</th>
            <th>Es Red ISOSPAM</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($organizaciones as $org)
        <tr>
            <td>{{ $org['nombre'] ?? '' }}</td>
            <td>{{ $org['zona'] ?? '' }}</td>
            <td>{{ isset($org['es_red_issopam']) && $org['es_red_issopam'] ? 'Sí' : 'No' }}</td>
            <td class="text-right">
                <a href="{{ route('organizacionpesquera.edit', $org['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('organizacionpesquera.destroy', $org['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
