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
            <div class="row">
                @foreach($viaje['respuestas_multifinalitaria'] as $r)
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ $r['nombre_pregunta'] ?? '' }}</label>
                        @switch($r['tipo_pregunta'])
                            @case('COMBO')
                                @php $opciones = json_decode($r['opciones'] ?? '[]', true) ?: []; @endphp
                                <select class="form-control" disabled>
                                    <option value="">Seleccione...</option>
                                    @foreach($opciones as $opt)
                                        @php
                                            $value = is_array($opt) ? ($opt['valor'] ?? '') : (string) $opt;
                                            $text = is_array($opt) ? ($opt['texto'] ?? '') : (string) $opt;
                                        @endphp
                                        <option value="{{ $value }}" @selected(($r['respuesta'] ?? '')==$value)>{{ $text }}</option>
                                    @endforeach
                                </select>
                                @break
                            @case('INTEGER')
                                <input type="number" class="form-control" value="{{ $r['respuesta'] ?? '' }}" readonly>
                                @break
                            @case('DATE')
                                <input type="date" class="form-control" value="{{ $r['respuesta'] ?? '' }}" readonly>
                                @break
                            @case('TIME')
                                <input type="time" class="form-control" value="{{ $r['respuesta'] ?? '' }}" readonly>
                                @break
                            @case('INPUT')
                            @default
                                <input type="text" class="form-control" value="{{ $r['respuesta'] ?? '' }}" readonly>
                        @endswitch
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Capturas</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nombre común</th>
                        <th>Especie</th>
                        <th>Nº Individuos</th>
                        <th>Peso Estimado</th>
                        <th>Peso Contado</th>
                        <th>Incidental</th>
                        <th>Descartada</th>
                        <th>Tipo Nº Individuos</th>
                        <th>Tipo Peso</th>
                        <th>Estado Producto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($capturas ?? [] as $c)
                        <tr>
                            <td>{{ $c['nombre_comun'] ?? '' }}</td>
                            <td>{{ $c['especie_nombre'] ?? '' }}</td>
                            <td>{{ $c['numero_individuos'] ?? '' }}</td>
                            <td>{{ $c['peso_estimado'] ?? '' }}</td>
                            <td>{{ $c['peso_contado'] ?? '' }}</td>
                            <td>{{ ($c['es_incidental'] ?? false) ? 'Sí' : 'No' }}</td>
                            <td>{{ ($c['es_descartada'] ?? false) ? 'Sí' : 'No' }}</td>
                            <td>{{ $c['tipo_numero_individuos'] ?? '' }}</td>
                            <td>{{ $c['tipo_peso'] ?? '' }}</td>
                            <td>{{ $c['estado_producto'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No hay capturas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Tripulantes</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Persona</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tripulantes ?? [] as $t)
                        <tr>
                            <td>{{ $t['tipo_tripulante_nombre'] ?? '' }}</td>
                            <td>{{ $t['tripulante_nombres'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No hay tripulantes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<a href="{{ route('viajes.pendientes') }}" class="btn btn-secondary">Volver</a>
@endsection
