@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($familia) ? 'Editar' : 'Nueva' }} Familia</h3>
<form method="POST" action="{{ isset($familia) ? route('familias.update', $familia['id']) : route('familias.store') }}">
    @csrf
    @if(isset($familia))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $familia['nombre'] ?? '') }}" required>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('familias.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@isset($familia)
    <hr>
    <div class="d-flex justify-content-between mb-3 mt-4">
        <h4>Peces</h4>
        <a href="{{ route('especies.create', ['familia_id' => $familia['id']]) }}" class="btn btn-xs btn-primary">Nuevo Pez</a>
    </div>
    <table class="table table-dark table-striped table-compact">
        <thead>
            <tr>
                <th>Nombre</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($especies ?? [] as $esp)
                <tr>
                    <td>{{ $esp['nombre'] ?? '' }}</td>
                    <td class="text-right">
                        <a href="{{ route('especies.edit', $esp['id']) }}" class="btn btn-xs btn-secondary">Editar</a>
                        <form action="{{ route('especies.destroy', $esp['id']) }}?familia_id={{ $familia['id'] }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset
@endsection
