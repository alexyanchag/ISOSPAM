@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Detalle del viaje</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Campaña</label>
                <input type="text" class="form-control" value="{{ $viaje['campania_descripcion'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Responsable Viaje</label>
                <input type="text" class="form-control" value="{{ $viaje['pescador_nombres'] ?? '' }} {{ $viaje['pescador_apellidos'] ?? '' }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Digitador</label>
                <input type="text" class="form-control" value="{{ $viaje['digitador_nombres'] ?? '' }} {{ $viaje['digitador_apellidos'] ?? '' }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Embarcación</label>
                <input type="text" class="form-control" value="{{ $viaje['embarcacion_nombre'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-lg-2 mb-3">
                <label class="form-label">Fecha Zarpe</label>
                <input type="date" class="form-control" value="{{ $viaje['fecha_zarpe'] ?? '' }}" readonly>
            </div>
            <div class="col-md-3 col-lg-2 mb-3">
                <label class="form-label">Hora Zarpe</label>
                <input type="time" class="form-control" value="{{ $viaje['hora_zarpe'] ?? '' }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Puerto Zarpe</label>
                <input type="text" class="form-control" value="{{ $viaje['puerto_zarpe_nombre'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-lg-2 mb-3">
                <label class="form-label">Fecha Arribo</label>
                <input type="date" class="form-control" value="{{ $viaje['fecha_arribo'] ?? '' }}" readonly>
            </div>
            <div class="col-md-3 col-lg-2 mb-3">
                <label class="form-label">Hora Arribo</label>
                <input type="time" class="form-control" value="{{ $viaje['hora_arribo'] ?? '' }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Puerto Arribo</label>
                <input type="text" class="form-control" value="{{ $viaje['puerto_arribo_nombre'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Muelle</label>
                <input type="text" class="form-control" value="{{ $viaje['muelle_nombre'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" readonly>{{ $viaje['observaciones'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>
@if(!empty($viaje['respuestas_multifinalitaria']))
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Campos dinámicos</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                @foreach($viaje['respuestas_multifinalitaria'] as $r)
                    <dt class="col-sm-4">{{ $r['nombre_pregunta'] ?? '' }}</dt>
                    <dd class="col-sm-8">{{ $r['respuesta'] ?? '' }}</dd>
                @endforeach
            </dl>
        </div>
    </div>
@endif

<a href="{{ route('viajes.pendientes') }}" class="btn btn-secondary">Volver</a>
@endsection
