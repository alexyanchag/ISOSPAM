@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Viajes pendientes</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-dark table-striped mb-0">
                <thead>
                    <tr>
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
                        <td>{{ $v['fecha_zarpe'] ?? '' }}</td>
                        <td>{{ $v['hora_zarpe'] ?? '' }}</td>
                        <td>{{ $v['fecha_arribo'] ?? '' }}</td>
                        <td>{{ $v['hora_arribo'] ?? '' }}</td>
                        <td>{{ $v['embarcacion_nombre'] ?? '' }}</td>
                        <td>{{ $v['campania_descripcion'] ?? '' }}</td>
                        <td>{{ ($v['pescador_nombres'] ?? '') . ' ' . ($v['pescador_apellidos'] ?? '') }}</td>
                        <td class="text-right">
                            <a href="{{ route('viajes.mostrar', $v['id']) }}" class="btn btn-sm btn-info">Mostrar</a>
                            <form method="POST" action="{{ route('viajes.seleccionar', $v['id']) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Seleccionar</button>
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
