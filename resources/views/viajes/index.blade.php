@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Viajes</h3>
        <div class="card-tools">
            <a href="{{ route('viajes.create') }}" class="btn btn-primary btn-xs">Nuevo</a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('viajes.index') }}" class="mb-3">
            <div class="form-row">
                <div class="col">
                    <input type="date" name="fecha_inicio" class="form-control" value="{{ $fechaInicio }}">
                </div>
                <div class="col">
                    <input type="date" name="fecha_fin" class="form-control" value="{{ $fechaFin }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-secondary">Filtrar</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-compact mb-0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha Zarpe</th>
            <th>Hora Zarpe</th>
            <th>Fecha Arribo</th>
            <th>Hora Arribo</th>
            <th>Embarcación</th>
            <th>Campaña</th>
            <th>Responsable</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($viajes as $v)
        <tr>
            <td>{{ $v['id'] ?? '' }}</td>
            <td>{{ $v['fecha_zarpe'] ?? '' }}</td>
            <td>{{ $v['hora_zarpe'] ?? '' }}</td>
            <td>{{ $v['fecha_arribo'] ?? '' }}</td>
            <td>{{ $v['hora_arribo'] ?? '' }}</td>
            <td>{{ $v['embarcacion_nombre'] ?? '' }}</td>
            <td>{{ $v['campania_descripcion'] ?? '' }}</td>
            <td>{{ ($v['pescador_nombres'] ?? '') . ' ' . ($v['pescador_apellidos'] ?? '') }}</td>
            <td class="text-right">
                <a href="{{ route('viajes.mostrar', ['viaje' => $v['id'], 'seleccionable' => 0]) }}" class="btn btn-xs btn-secondary">Ver</a>
                <form action="{{ route('viajes.destroy', $v['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
            </table>
        </div>
    </div>
</div>
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
