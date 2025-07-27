@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($organizacion) ? 'Editar' : 'Nueva' }} Organización Pesquera</h3>
<form method="POST" action="{{ isset($organizacion) ? route('organizacionpesquera.update', $organizacion['id']) : route('organizacionpesquera.store') }}">
    @csrf
    @if(isset($organizacion))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $organizacion['nombre'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Zona</label>
        <input type="text" name="zona" class="form-control" value="{{ old('zona', $organizacion['zona'] ?? '') }}" required>
    </div>
    <div class="mb-3 form-check">
        <input type="hidden" name="es_red_issopam" value="0" />
        <input type="checkbox" name="es_red_issopam" value="1" class="form-check-input" id="es_red" {{ old('es_red_issopam', $organizacion['es_red_issopam'] ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="es_red">Pertenece a Red ISSOPAM</label>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('organizacionpesquera.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@if(isset($organizacion))
    <hr>
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h4>Responsables</h4>
            <a href="{{ route('asignacionresponsable.create') }}?organizacion_pesquera_id={{ $organizacion['id'] }}" class="btn btn-primary btn-sm">Nueva</a>
        </div>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Responsable</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($asignaciones ?? [] as $asignacion)
                <tr>
                    <td>{{ ($asignacion['nombres'] ?? '') . ' ' . ($asignacion['apellidos'] ?? '') }}</td>
                    <td>{{ $asignacion['fecha_inicio'] ?? '' }}</td>
                    <td>{{ $asignacion['fecha_fin'] ?? '' }}</td>
                    <td>{{ $asignacion['estado'] ?? '' }}</td>
                    <td class="text-right">
                        <a href="{{ route('asignacionresponsable.edit', $asignacion['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form action="{{ route('asignacionresponsable.destroy', $asignacion['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection
