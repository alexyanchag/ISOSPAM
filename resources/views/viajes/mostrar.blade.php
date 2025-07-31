@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalle del viaje</h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4">Fecha Zarpe</dt>
            <dd class="col-sm-8">{{ $viaje['fecha_zarpe'] ?? '' }} {{ $viaje['hora_zarpe'] ?? '' }}</dd>
            <dt class="col-sm-4">Fecha Arribo</dt>
            <dd class="col-sm-8">{{ $viaje['fecha_arribo'] ?? '' }} {{ $viaje['hora_arribo'] ?? '' }}</dd>
            <dt class="col-sm-4">Embarcación</dt>
            <dd class="col-sm-8">{{ $viaje['embarcacion_nombre'] ?? '' }}</dd>
            <dt class="col-sm-4">Campaña</dt>
            <dd class="col-sm-8">{{ $viaje['campania_descripcion'] ?? '' }}</dd>
            <dt class="col-sm-4">Responsable</dt>
            <dd class="col-sm-8">{{ ($viaje['pescador_nombres'] ?? '') . ' ' . ($viaje['pescador_apellidos'] ?? '') }}</dd>
            <dt class="col-sm-4">Observaciones</dt>
            <dd class="col-sm-8">{{ $viaje['observaciones'] ?? '' }}</dd>
        </dl>
    </div>
    <div class="card-footer">
        <a href="{{ route('viajes.pendientes') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
