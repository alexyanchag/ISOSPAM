@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Asignaciones de Responsable @if($organizacion) de {{ $organizacion['nombre'] ?? '' }} @endif</h3>
    <a href="{{ route('asignacionresponsable.create', $organizacionId ? ['organizacion_pesquera_id' => $organizacionId] : []) }}" class="btn btn-primary">Nueva</a>
</div>


<table class="table table-dark table-striped table-compact">
    <thead>
        <tr>
            <th>Organización</th>
            <th>Presidente</th>
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
                <a href="{{ route('asignacionresponsable.edit', $asignacion['id']) }}{{ $organizacionId ? '?organizacion_pesquera_id='.$organizacionId : '' }}" class="btn btn-xs btn-secondary">Editar</a>
                <form action="{{ route('asignacionresponsable.destroy', $asignacion['id']) }}{{ $organizacionId ? '?organizacion_pesquera_id='.$organizacionId : '' }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
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

@section('scripts')
@if(session('success'))
    <script>
        Swal.fire({icon: 'success', title: 'Éxito', text: @json(session('success'))});
    </script>
@endif
@if($errors->any())
    <script>
        Swal.fire({icon: 'error', title: 'Error', html: `<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`});
    </script>
@endif
@endsection
