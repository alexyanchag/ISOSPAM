@extends('layouts.dashboard')

@section('spinner')
<x-spinner />
@endsection


@section('content')
<form id="viaje-form">
<fieldset disabled>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalle del Viaje</h3>
            <div class="card-tools">
                <a href="{{ route('viajes.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Campaña <span class="text-danger">*</span></label>
                    <select name="campania_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($campanias as $c)
                        <option value="{{ $c['id'] }}" @selected(old('campania_id', $viaje['campania_id'] ?? ''
                            )==$c['id'])>{{ $c['descripcion'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('campania_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Responsable Viaje <span class="text-danger">*</span></label>
                    <select id="responsable-select" name="persona_idpersona" class="form-control select2">
                        <option value="">Seleccione...</option>
                        @foreach($responsables as $per)
                        <option value="{{ $per['idpersona'] }}" @selected(old('persona_idpersona',
                            $viaje['persona_idpersona'] ?? '' )==$per['idpersona'])>{{ $per['nombres'] ?? '' }}
                            {{ $per['apellidos'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('persona_idpersona')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Digitador <span class="text-danger">*</span></label>
                    <select id="digitador-select" name="digitador_id" class="form-control select2">
                        <option value="">Seleccione...</option>
                        @foreach($digitadores as $d)
                        <option value="{{ $d['idpersona'] }}" @selected(old('digitador_id', $viaje['digitador_id'] ?? ''
                            )==$d['idpersona'])>{{ $d['nombres'] ?? '' }} {{ $d['apellidos'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('digitador_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Embarcación <span class="text-danger">*</span></label>
                    <select name="embarcacion_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($embarcaciones as $e)
                        <option value="{{ $e['id'] }}" @selected(old('embarcacion_id', $viaje['embarcacion_id'] ?? ''
                            )==$e['id'])>{{ $e['nombre'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('embarcacion_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-lg-2 mb-3">
                    <label class="form-label">Fecha Zarpe <span class="text-danger">*</span></label>
                    <input type="date" name="fecha_zarpe" id="fecha_zarpe" class="form-control"
                        value="{{ old('fecha_zarpe', $viaje['fecha_zarpe'] ?? '') }}">
                    @error('fecha_zarpe')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 col-lg-2 mb-3">
                    <label class="form-label">Hora Zarpe <span class="text-danger">*</span></label>
                    <input type="time" name="hora_zarpe" id="hora_zarpe" class="form-control"
                        value="{{ old('hora_zarpe', $viaje['hora_zarpe'] ?? '') }}">
                    @error('hora_zarpe')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Puerto Zarpe <span class="text-danger">*</span></label>
                    <select name="puerto_zarpe_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($puertos as $p)
                        <option value="{{ $p['id'] }}" @selected(old('puerto_zarpe_id', $viaje['puerto_zarpe_id'] ?? ''
                            )==$p['id'])>{{ $p['nombre'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('puerto_zarpe_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-lg-2 mb-3">
                    <label class="form-label">Fecha Arribo <span class="text-danger">*</span></label>
                    <input type="date" name="fecha_arribo" id="fecha_arribo" class="form-control"
                        value="{{ old('fecha_arribo', $viaje['fecha_arribo'] ?? '') }}">
                    @error('fecha_arribo')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 col-lg-2 mb-3">
                    <label class="form-label">Hora Arribo <span class="text-danger">*</span></label>
                    <input type="time" name="hora_arribo" id="hora_arribo" class="form-control"
                        value="{{ old('hora_arribo', $viaje['hora_arribo'] ?? '') }}">
                    @error('hora_arribo')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Puerto Arribo <span class="text-danger">*</span></label>
                    <select name="puerto_arribo_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($puertos as $p)
                        <option value="{{ $p['id'] }}" @selected(old('puerto_arribo_id', $viaje['puerto_arribo_id']
                            ?? '' )==$p['id'])>{{ $p['nombre'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('puerto_arribo_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Muelle</label>
                    <select name="muelle_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($muelles as $m)
                        <option value="{{ $m['id'] }}" @selected(old('muelle_id', $viaje['muelle_id'] ?? ''
                            )==$m['id'])>
                            {{ $m['nombre'] ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('muelle_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Observaciones <span class="text-danger">*</span></label>
                    <textarea name="observaciones"
                        class="form-control">{{ old('observaciones', $viaje['observaciones'] ?? '') }}</textarea>
                    @error('observaciones')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3" id="campos-dinamicos-card">
        <div class="card-header">
            <h3 class="card-title">Campos dinámicos</h3>
        </div>
        <div class="card-body" id="campos-dinamicos-body">
            @php
            $respuestas = collect(old('respuestas_multifinalitaria', $viaje['respuestas_multifinalitaria'] ?? []))
            ->keyBy('tabla_multifinalitaria_id');
            @endphp
            <div class="row">
                @forelse($camposDinamicos ?? [] as $campo)
                @php
                $resp = $respuestas->get($campo['id'], []);
                $required = !empty($campo['requerido']) ? 'required' : '';
                @endphp
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ $campo['nombre_pregunta'] ?? '' }} @if($required)<span
                            class="text-danger">*</span>@endif</label>
                    @switch($campo['tipo_pregunta'])
                    @case('COMBO')
                    @php $opciones = json_decode($campo['opciones'] ?? '[]', true) ?: []; @endphp
                    <select name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]" class="form-control" {{
                        $required }}>
                        <option value="">Seleccione...</option>
                        @foreach($opciones as $opt)
                        @php
                        $value = is_array($opt) ? ($opt['valor'] ?? '') : (string) $opt;
                        $text = is_array($opt) ? ($opt['texto'] ?? '') : (string) $opt;
                        @endphp
                        <option value="{{ $value }}" @selected(($resp['respuesta'] ?? '' )==$value)>{{ $text }}</option>
                        @endforeach
                    </select>
                    @break
                    @case('INTEGER')
                    <input type="number" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]"
                        class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                    @break
                    @case('DATE')
                    <input type="date" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]"
                        class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                    @break
                    @case('TIME')
                    <input type="time" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]"
                        class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                    @break
                    @case('INPUT')
                    @default
                    <input type="text" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]"
                        class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                    @endswitch
                    @if(!empty($campo['id']))
                    <input type="hidden"
                        name="respuestas_multifinalitaria[{{ $loop->index }}][tabla_multifinalitaria_id]"
                        value="{{ $campo['id'] }}">
                    @endif
                    @if(isset($resp['id']))
                    <input type="hidden" name="respuestas_multifinalitaria[{{ $loop->index }}][id]"
                        value="{{ $resp['id'] }}">
                    @endif
                </div>
                @empty
                <p class="col-12 mb-0">No hay campos dinámicos para la campaña seleccionada.</p>
                @endforelse
            </div>
        </div>
    </div>
</fieldset>
</form>

@isset($viaje)


<div class="card mt-3">

    <div class="card-header border-0 bg-dark">
        <h3 class="card-title">
            <i class="fas fa-th mr-1"></i>
            Capturas
        </h3>

        <div class="card-tools">
            <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body collapse show" id="capturas-collapse">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-compact mb-0" id="capturas-table">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($capturas ?? [] as $c)
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
                        <td class="text-right">
                            <button class="btn btn-xs btn-secondary ver-captura" data-id="{{ $c['id'] }}">Ver
                                detalles</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header border-0 bg-dark">
        <h3 class="card-title">
            <i class="fas fa-user-friends mr-1"></i>
            Tripulantes
        </h3>

        <div class="card-tools">
            <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body collapse show" id="tripulantes-collapse">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-compact mb-0" id="tripulantes-table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Persona</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tripulantes ?? [] as $t)
                    <tr>
                        <td>{{ $t['tipo_tripulante_nombre'] ?? '' }}</td>
                        <td>{{ $t['tripulante_nombres'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header border-0 bg-dark">
        <h3 class="card-title">
            <i class="fas fa-users mr-1"></i>
            Observadores
        </h3>

        <div class="card-tools">
            <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body collapse show" id="observadores-collapse">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-compact mb-0" id="observadores-table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Persona</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($observadores ?? [] as $o)
                    <tr>
                        <td>{{ $o['tipo_observador_descripcion'] ?? '' }}</td>
                        <td>{{ $o['persona_nombres'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="captura-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Ampliado horizontalmente -->
        <div class="modal-content">
            <form id="captura-form" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title">Captura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Scroll interno en el cuerpo -->
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <input type="hidden" id="captura-id">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nombre común <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre_comun" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Especie <span class="text-danger">*</span></label>
                                <select class="form-control" id="especie_id" required>
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tipo Nº Individuos <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipo_numero_individuos" required>
                                    <option value="">Seleccione...</option>
                                    <option value="ESTIMADO">Estimado</option>
                                    <option value="MEDIDO">Medido</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nº Individuos <span class="text-danger">*</span></label>
                                <input type="number" min="0" step="1" class="form-control no-negative"
                                    id="numero_individuos" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tipo Peso <span class="text-danger">*</span></label>
                                <select class="form-control" id="tipo_peso" required>
                                    <option value="">Seleccione...</option>
                                    <option value="ESTIMADO">Estimado</option>
                                    <option value="MEDIDO">Medido</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Peso de captura <span class="text-danger">*</span></label>
                                <input type="number" step="any" min="0" class="form-control no-negative"
                                    id="peso_estimado" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Estado Producto <span class="text-danger">*</span></label>
                                <select class="form-control" id="estado_producto" required>
                                    <option value="">Seleccione...</option>
                                    <option value="EVISCERADO">Eviscerado</option>
                                    <option value="ENTERO">Entero</option>
                                    <option value="SIN CABEZA">Sin cabeza</option>
                                    <option value="En cola (camaron)">En cola (camaron)</option>
                                    <option value="Pulpa(concha)">Pulpa(concha)</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Es Incidental <span class="text-danger">*</span></label>
                                <select class="form-control" id="es_incidental" required>
                                    <option value="">Seleccione...</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Es Descartada <span class="text-danger">*</span></label>
                                <select class="form-control" id="es_descartada" required>
                                    <option value="">Seleccione...</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div id="campos-dinamicos-captura" class="row"></div>

                        <div id="sitio-pesca-card" class="card mb-3 collapsed-card">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Sitio de pesca</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <input type="hidden" id="sitio-pesca-id">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Sitio existente <span
                                                class="text-danger">*</span></label>
                                        <select id="sitio-id" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" id="sitio-nombre" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Profundidad <span class="text-danger">*</span></label>
                                        <input type="number" id="sitio-profundidad" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Unidad de profundidad <span
                                                class="text-danger">*</span></label>
                                        <select id="sitio-unidad-profundidad" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Latitud <span class="text-danger">*</span></label>
                                        <input type="text" id="sitio-latitud" class="form-control" required readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label">Longitud <span class="text-danger">*</span></label>
                                        <input type="text" id="sitio-longitud" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="arte-pesca-card" class="card mb-3 collapsed-card">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Arte de pesca</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <input type="hidden" id="arte-pesca-id">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Tipo de arte <span class="text-danger">*</span></label>
                                        <select id="tipo-arte-id" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 arte-linea-madre d-none">
                                        <label>Líneas madre</label>
                                        <input type="number" id="lineas-madre" class="form-control">
                                    </div>
                                </div>

                                <div class="arte-linea">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Anzuelos</label>
                                            <input type="number" id="anzuelos" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Tipo anzuelo</label>
                                            <select id="tipo-anzuelo-id" class="form-control">
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Tamaño anzuelo (pulg)</label>
                                            <input type="number" step="any" id="tamanio-anzuelo-pulg"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Carnada viva</label>
                                            <select id="carnadaviva" class="form-control">
                                                <option value="">Seleccione...</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Especie carnada</label>
                                            <input type="text" id="especie-carnada" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="arte-enmalle">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Largo red (m)</label>
                                            <input type="number" step="any" id="largo-red-m" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Ancho red (m)</label>
                                            <input type="number" step="any" id="alto-red-m" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Material malla</label>
                                            <select id="material-malla-id" class="form-control">
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Ojo malla (cm)</label>
                                            <input type="number" step="any" id="ojo-malla-cm" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Diámetro</label>
                                            <input type="number" step="any" id="diametro" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="economia-venta-card" class="card mb-3 collapsed-card">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Dato económico</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <input type="hidden" id="economia-venta-id">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Vendido a</label>
                                        <input type="text" id="vendido-a" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Destino</label>
                                        <input type="text" id="destino" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Precio</label>
                                        <input type="number" step="any" id="precio" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Unidad de venta</label>
                                        <select id="unidad-venta-id" class="form-control">
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="dato-biologico-card" class="card mb-3 collapsed-card">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Dato biológico</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-compact mb-0" id="datos-biologicos-table">
                                        <thead>
                                            <tr>
                                                <th>Longitud</th>
                                                <th>Peso</th>
                                                <th>Sexo</th>
                                                <th>Ovada</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="archivo-captura-card" class="card mb-3 collapsed-card">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Archivos</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-compact mb-0" id="archivos-captura-table">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Tamaño</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header border-0 bg-dark">
        <h3 class="card-title">
            <i class="fas fa-water mr-1"></i>
            Parámetros Ambientales
        </h3>
        <div class="card-tools">
            <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body collapse show" id="parametros-ambientales-collapse">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-compact mb-0" id="parametros-ambientales-table">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Sondeo PPT</th>
                        <th>TSMP</th>
                        <th>Estado Marea</th>
                        <th>Condición Mar</th>
                        <th>Oxígeno mg/l</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parametrosAmbientales ?? [] as $p)
                    <tr>
                        <td>{{ $p['hora'] ?? '' }}</td>
                        <td>{{ $p['sondeo_ppt'] ?? '' }}</td>
                        <td>{{ $p['tsmp'] ?? '' }}</td>
                        <td>{{ $p['estado_marea_descripcion'] ?? '' }}</td>
                        <td>{{ $p['condicion_mar_descripcion'] ?? '' }}</td>
                        <td>{{ $p['oxigeno_mg_l'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header border-0 bg-dark">
        <h3 class="card-title">
            <i class="fas fa-coins mr-1"></i>
            Economía de Insumos
        </h3>
        <div class="card-tools">
            <button type="button" class="btn bg-gray btn-xs" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body collapse show" id="economia-insumo-collapse">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-compact mb-0" id="economia-insumo-table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($economiaInsumos ?? [] as $e)
                    <tr>
                        <td>{{ $e['nombre_tipo'] ?? '' }}</td>
                        <td>{{ $e['nombre_unidad'] ?? '' }}</td>
                        <td>{{ $e['cantidad'] ?? '' }}</td>
                        <td>{{ $e['precio'] ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endisset
@endsection

@section('scripts')
<script>
    $(function () {
        const ajaxBase = "{{ url('ajax') }}";

        function renderCamposDinamicosCaptura(campos = [], respuestas = []) {
            const row = $('#campos-dinamicos-captura').empty();
            if (!campos.length) {
                row.append('<p class="col-12 mb-0">No hay campos dinámicos para la campaña seleccionada.</p>');
                return;
            }
            const respMap = {};
            (respuestas || []).forEach(r => { respMap[r.tabla_multifinalitaria_id] = r; });
            campos.forEach(function (campo, index) {
                var control = '';
                var resp = respMap[campo.id] || {};
                var key = campo.id != null ? campo.id : index;
                switch (campo.tipo_pregunta) {
                    case 'COMBO':
                        var opciones = [];
                        try { opciones = JSON.parse(campo.opciones || '[]'); } catch (e) { }
                        control = '<select class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" disabled><option value="">Seleccione...</option>';
                        opciones.forEach(function (opt) {
                            var value = (typeof opt === 'object') ? (opt.valor || '') : String(opt);
                            var text = (typeof opt === 'object') ? (opt.texto || '') : String(opt);
                            var selected = (resp.respuesta || '') == value ? ' selected' : '';
                            control += '<option value="' + value + '"' + selected + '>' + text + '</option>';
                        });
                        control += '</select>';
                        break;
                    case 'TEXTO':
                        control = '<input type="text" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                        break;
                    case 'NUMERO':
                        control = '<input type="number" step="any" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                        break;
                    case 'FECHA':
                        control = '<input type="date" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                        break;
                    default:
                        control = '<input type="text" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                }
                row.append('<div class="form-group col-md-4"><label>' + (campo.nombre_pregunta || '') + '</label>' + control + '</div>');
            });
        }

        function cargarUnidadesProfundidad(selected = '') {
            const select = $('#sitio-unidad-profundidad');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.unidades-profundidad') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(u => {
                        const opt = new Option(u.nombre || u.descripcion || '', u.id, false, String(u.id) === String(selected));
                        select.append(opt);
                    });
                });
        }

        let sitiosCache = [];
        function cargarSitios(selected = '') {
            const select = $('#sitio-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.sitios') }}")
                .then(r => r.json())
                .then(data => {
                    sitiosCache = Array.isArray(data) ? data : [];
                    sitiosCache.forEach(s => {
                        const opt = new Option(s.nombre || '', s.id, false, String(s.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarTiposArte(selected = '') {
            const select = $('#tipo-arte-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.tipos-arte') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.nombre || t.descripcion || '', t.id, false, String(t.id) === String(selected));
                        if (t.tipo !== undefined && t.tipo !== null) { opt.dataset.tipo = t.tipo; }
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarTiposAnzuelo(selected = '') {
            const select = $('#tipo-anzuelo-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.tipos-anzuelo') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.nombre || t.descripcion || '', t.id, false, String(t.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarMaterialesMalla(selected = '') {
            const select = $('#material-malla-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.materiales-malla') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(m => {
                        const opt = new Option(m.nombre || m.descripcion || '', m.id, false, String(m.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarUnidadesVenta(selected = '') {
            const select = $('#unidad-venta-id').empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.unidades-venta') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(u => {
                        const opt = new Option(u.nombre || u.descripcion || '', u.id, false, String(u.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarEconomiaVenta(capturaId) {
            return fetch(`${ajaxBase}/economia-ventas?captura_id=${capturaId}`)
                .then(r => r.ok ? r.json() : [])
                .then(data => {
                    const ev = Array.isArray(data) && data.length ? data[0] : null;
                    $('#economia-venta-id').val(ev?.id || '');
                    $('#vendido-a').val(ev?.vendido_a || '');
                    $('#destino').val(ev?.destino || '');
                    $('#precio').val(ev?.precio || '');
                    return cargarUnidadesVenta(ev?.unidad_venta_id || '');
                })
                .catch(() => cargarUnidadesVenta(''));
        }

        function cargarDatosBiologicos(capturaId) {
            if (!capturaId) {
                $('#datos-biologicos-table tbody').empty();
                return Promise.resolve();
            }
            return fetch(`${ajaxBase}/datos-biologicos?captura_id=${capturaId}`)
                .then(r => r.ok ? r.json() : [])
                .then(data => {
                    const tbody = $('#datos-biologicos-table tbody').empty();
                    (data || []).forEach(d => {
                        const row = `<tr>
                                <td>${d.longitud ?? ''}</td>
                                <td>${d.peso ?? ''}</td>
                                <td>${d.sexo ?? ''}</td>
                                <td>${d.ovada ? 'Sí' : 'No'}</td>
                                <td>${d.estado_desarrollo_gonadal_descripcion ?? ''}</td>
                            </tr>`;
                        tbody.append(row);
                    });
                })
                .catch(() => { $('#datos-biologicos-table tbody').empty(); });
        }

        function cargarArchivos(capturaId) {
            if (!capturaId) {
                $('#archivos-captura-table tbody').empty();
                return Promise.resolve();
            }
            return fetch(`/ajax/capturas/${capturaId}/archivos`)
                .then(r => r.ok ? r.json() : [])
                .then(data => {
                    const tbody = $('#archivos-captura-table tbody').empty();
                    (data || []).forEach(a => {
                        const row = `<tr>
                                <td><a href="${a.url}" target="_blank">${a.nombre_original}</a></td>
                                <td>${a.tamano ?? ''}</td>
                            </tr>`;
                        tbody.append(row);
                    });
                })
                .catch(() => { $('#archivos-captura-table tbody').empty(); });
        }

        const ARTE_RULES = {
            default: {
                show: ['#tipo-arte-id'],
                hide: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                reset: []
            },
            'LÍNEA MANO, PALANGRE': {
                show: ['#tipo-arte-id', '#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada'],
                hide: ['#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                reset: []
            },
            'ENMALLE/TRASMALLO': {
                show: ['#tipo-arte-id', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                hide: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada'],
                reset: []
            }
        };

        function setFieldVisibility(selector, show) {
            const $fg = $(selector).closest('.form-group');
            if (show) {
                $fg.removeClass('d-none');
            } else {
                $fg.addClass('d-none');
            }
        }

        function changeArtePesca(id) {
            const opt = $('#tipo-arte-id option').filter(function () { return String(this.value) === String(id); }).first();
            const tipo = String(opt.data('tipo') || '').toUpperCase();
            const rules = ARTE_RULES[tipo] || ARTE_RULES.default;
            ARTE_RULES.default.hide.forEach(s => setFieldVisibility(s, true));
            rules.hide.forEach(s => setFieldVisibility(s, false));
            rules.show.forEach(s => setFieldVisibility(s, true));
        }

        function abrirModal(data = {}) {
            $('#captura-id').val(data.id || '');
            $('#nombre_comun').val(data.nombre_comun || '');
            const especieSelect = $('#especie_id');
            if (data.especie_id) {
                const opt = new Option(data.especie_nombre || '', data.especie_id, true, true);
                especieSelect.append(opt).trigger('change');
            } else {
                especieSelect.val(null).trigger('change');
            }
            $('#tipo_numero_individuos').val(data.tipo_numero_individuos || '');
            $('#numero_individuos').val(data.numero_individuos || '');
            $('#tipo_peso').val(data.tipo_peso || '');
            $('#peso_estimado').val(data.peso_estimado || '');
            $('#estado_producto').val(data.estado_producto || '');
            $('#es_incidental').val(data.es_incidental === undefined || data.es_incidental === null ? '' : (data.es_incidental ? '1' : '0'));
            $('#es_descartada').val(data.es_descartada === undefined || data.es_descartada === null ? '' : (data.es_descartada ? '1' : '0'));

            const promises = [];
            if (data.id) {
                promises.push(
                    fetch(`${ajaxBase}/sitios-pesca?captura_id=${data.id}`)
                        .then(r => r.ok ? r.json() : [])
                        .then(sitios => {
                            let s = sitios.length ? sitios[0] : {};
                            $('#sitio-pesca-id').val(s.id || '');
                            $('#sitio-id').val(s.sitio_id || '');
                            $('#sitio-nombre').val(s.nombre || '');
                            $('#sitio-profundidad').val(s.profundidad || '');
                            $('#sitio-unidad-profundidad').val(s.unidad_profundidad_id || '');
                            $('#sitio-latitud').val(s.latitud || '');
                            $('#sitio-longitud').val(s.longitud || '');
                            return Promise.all([
                                cargarUnidadesProfundidad(s.unidad_profundidad_id || ''),
                                cargarSitios(s.sitio_id || '')
                            ]);
                        })
                        .catch(() => Promise.all([cargarUnidadesProfundidad(''), cargarSitios('')]))
                );

                promises.push(
                    fetch(`${ajaxBase}/artes-pesca?captura_id=${data.id}`)
                        .then(r => r.ok ? r.json() : [])
                        .then(artes => {
                            let a = artes.length ? artes[0] : {};
                            $('#arte-pesca-id').val(a.id || '');
                            $('#lineas-madre').val(a.lineas_madre || '');
                            $('#anzuelos').val(a.anzuelos || '');
                            $('#tamanio-anzuelo-pulg').val(a.tamanio_anzuelo_pulg || '');
                            $('#largo-red-m').val(a.largo_red_m || '');
                            $('#alto-red-m').val(a.alto_red_m || '');
                            $('#ojo-malla-cm').val(a.ojo_malla_cm || '');
                            $('#diametro').val(a.diametro || '');
                            $('#especie-carnada').val(a.especiecarnada || '');
                            $('#carnadaviva').val(a.carnadaviva === undefined || a.carnadaviva === null ? '' : (a.carnadaviva ? '1' : '0'));
                            return Promise.all([
                                cargarTiposArte(a.tipo_arte_id || ''),
                                cargarTiposAnzuelo(a.tipo_anzuelo_id || ''),
                                cargarMaterialesMalla(a.material_malla_id || '')
                            ]);
                        })
                        .catch(() => Promise.all([cargarTiposArte(''), cargarTiposAnzuelo(''), cargarMaterialesMalla('')]))
                );

                promises.push(cargarEconomiaVenta(data.id));
                promises.push(cargarDatosBiologicos(data.id));
                promises.push(cargarArchivos(data.id));

                const campos = (data.respuestas_multifinalitaria || []).map(r => ({
                    id: r.tabla_multifinalitaria_id,
                    nombre_pregunta: r.tabla_multifinalitaria_nombre_pregunta || r.nombre_pregunta,
                    tipo_pregunta: r.tabla_multifinalitaria_tipo_pregunta || r.tipo_pregunta,
                    opciones: r.tabla_multifinalitaria_opciones || r.opciones,
                    requerido: r.tabla_multifinalitaria_requerido || r.requerido,
                }));
                renderCamposDinamicosCaptura(campos, data.respuestas_multifinalitaria || []);
            }

            Promise.all(promises).finally(() => {
                $('#captura-form :input').not('[data-card-widget="collapse"]').not('[data-dismiss="modal"]').prop('disabled', true);
                changeArtePesca($('#tipo-arte-id').val());
                $('#captura-modal').one('shown.bs.modal', function () {
                    $('.spinner-overlay').addClass('d-none');
                }).modal('show');
            });
        }

        function verCaptura(id) {
            $('.spinner-overlay').removeClass('d-none');
            $.ajax({
                url: `${ajaxBase}/capturas/${id}`,
                global: false,
                success: data => abrirModal(data),
                error: () => $('.spinner-overlay').addClass('d-none')
            });
        }

        $('#capturas-table').on('click', '.ver-captura', function () { verCaptura($(this).data('id')); });
    });
</script>
@endsection

@section('scripts')
<script>
    $(function () {
        const ajaxBase = "{{ url('ajax') }}";

        function renderCamposDinamicosCaptura(campos = [], respuestas = []) {
            const row = $('#campos-dinamicos-captura').empty();
            if (!campos.length) {
                row.append('<p class="col-12 mb-0">No hay campos dinámicos para la campaña seleccionada.</p>');
                return;
            }
            const respMap = {};
            (respuestas || []).forEach(r => { respMap[r.tabla_multifinalitaria_id] = r; });
            campos.forEach(function (campo, index) {
                var control = '';
                var resp = respMap[campo.id] || {};
                var key = campo.id != null ? campo.id : index;
                switch (campo.tipo_pregunta) {
                    case 'COMBO':
                        var opciones = [];
                        try { opciones = JSON.parse(campo.opciones || '[]'); } catch (e) { }
                        control = '<select class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" disabled><option value="">Seleccione...</option>';
                        opciones.forEach(function (opt) {
                            var value = (typeof opt === 'object') ? (opt.valor || '') : String(opt);
                            var text = (typeof opt === 'object') ? (opt.texto || '') : String(opt);
                            var selected = (resp.respuesta || '') == value ? ' selected' : '';
                            control += '<option value="' + value + '"' + selected + '>' + text + '</option>';
                        });
                        control += '</select>';
                        break;
                    case 'TEXTO':
                        control = '<input type="text" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                        break;
                    case 'NUMERO':
                        control = '<input type="number" step="any" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                        break;
                    case 'FECHA':
                        control = '<input type="date" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                        break;
                    default:
                        control = '<input type="text" class="form-control" name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '" disabled>';
                }
                row.append('<div class="form-group col-md-4"><label>' + (campo.nombre_pregunta || '') + '</label>' + control + '</div>');
            });
        }

        function cargarUnidadesProfundidad(selected = '') {
            const select = $('#sitio-unidad-profundidad');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.unidades-profundidad') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(u => {
                        const opt = new Option(u.nombre || u.descripcion || '', u.id, false, String(u.id) === String(selected));
                        select.append(opt);
                    });
                });
        }

        let sitiosCache = [];
        function cargarSitios(selected = '') {
            const select = $('#sitio-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.sitios') }}")
                .then(r => r.json())
                .then(data => {
                    sitiosCache = Array.isArray(data) ? data : [];
                    sitiosCache.forEach(s => {
                        const opt = new Option(s.nombre || '', s.id, false, String(s.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarTiposArte(selected = '') {
            const select = $('#tipo-arte-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.tipos-arte') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.nombre || t.descripcion || '', t.id, false, String(t.id) === String(selected));
                        if (t.tipo !== undefined && t.tipo !== null) { opt.dataset.tipo = t.tipo; }
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarTiposAnzuelo(selected = '') {
            const select = $('#tipo-anzuelo-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.tipos-anzuelo') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.nombre || t.descripcion || '', t.id, false, String(t.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarMaterialesMalla(selected = '') {
            const select = $('#material-malla-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.materiales-malla') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(m => {
                        const opt = new Option(m.nombre || m.descripcion || '', m.id, false, String(m.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarUnidadesVenta(selected = '') {
            const select = $('#unidad-venta-id').empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.unidades-venta') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(u => {
                        const opt = new Option(u.nombre || u.descripcion || '', u.id, false, String(u.id) === String(selected));
                        select.append(opt);
                    });
                    select.val(selected);
                });
        }

        function cargarEconomiaVenta(capturaId) {
            return fetch(`${ajaxBase}/economia-ventas?captura_id=${capturaId}`)
                .then(r => r.ok ? r.json() : [])
                .then(data => {
                    const ev = Array.isArray(data) && data.length ? data[0] : null;
                    $('#economia-venta-id').val(ev?.id || '');
                    $('#vendido-a').val(ev?.vendido_a || '');
                    $('#destino').val(ev?.destino || '');
                    $('#precio').val(ev?.precio || '');
                    return cargarUnidadesVenta(ev?.unidad_venta_id || '');
                })
                .catch(() => cargarUnidadesVenta(''));
        }

        function cargarDatosBiologicos(capturaId) {
            if (!capturaId) {
                $('#datos-biologicos-table tbody').empty();
                return Promise.resolve();
            }
            return fetch(`${ajaxBase}/datos-biologicos?captura_id=${capturaId}`)
                .then(r => r.ok ? r.json() : [])
                .then(data => {
                    const tbody = $('#datos-biologicos-table tbody').empty();
                    (data || []).forEach(d => {
                        const row = `<tr>
                                <td>${d.longitud ?? ''}</td>
                                <td>${d.peso ?? ''}</td>
                                <td>${d.sexo ?? ''}</td>
                                <td>${d.ovada ? 'Sí' : 'No'}</td>
                                <td>${d.estado_desarrollo_gonadal_descripcion ?? ''}</td>
                            </tr>`;
                        tbody.append(row);
                    });
                })
                .catch(() => { $('#datos-biologicos-table tbody').empty(); });
        }

        function cargarArchivos(capturaId) {
            if (!capturaId) {
                $('#archivos-captura-table tbody').empty();
                return Promise.resolve();
            }
            return fetch(`/ajax/capturas/${capturaId}/archivos`)
                .then(r => r.ok ? r.json() : [])
                .then(data => {
                    const tbody = $('#archivos-captura-table tbody').empty();
                    (data || []).forEach(a => {
                        const row = `<tr>
                                <td><a href="${a.url}" target="_blank">${a.nombre_original}</a></td>
                                <td>${a.tamano ?? ''}</td>
                            </tr>`;
                        tbody.append(row);
                    });
                })
                .catch(() => { $('#archivos-captura-table tbody').empty(); });
        }

        const ARTE_RULES = {
            default: {
                show: ['#tipo-arte-id'],
                hide: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                reset: []
            },
            'LÍNEA MANO, PALANGRE': {
                show: ['#tipo-arte-id', '#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada'],
                hide: ['#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                reset: []
            },
            'ENMALLE/TRASMALLO': {
                show: ['#tipo-arte-id', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                hide: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada'],
                reset: []
            }
        };

        function setFieldVisibility(selector, show) {
            const $fg = $(selector).closest('.form-group');
            if (show) {
                $fg.removeClass('d-none');
            } else {
                $fg.addClass('d-none');
            }
        }

        function changeArtePesca(id) {
            const opt = $('#tipo-arte-id option').filter(function () { return String(this.value) === String(id); }).first();
            const tipo = String(opt.data('tipo') || '').toUpperCase();
            const rules = ARTE_RULES[tipo] || ARTE_RULES.default;
            ARTE_RULES.default.hide.forEach(s => setFieldVisibility(s, true));
            rules.hide.forEach(s => setFieldVisibility(s, false));
            rules.show.forEach(s => setFieldVisibility(s, true));
        }

        function abrirModal(data = {}) {
            $('#captura-id').val(data.id || '');
            $('#nombre_comun').val(data.nombre_comun || '');
            const especieSelect = $('#especie_id');
            if (data.especie_id) {
                const opt = new Option(data.especie_nombre || '', data.especie_id, true, true);
                especieSelect.append(opt).trigger('change');
            } else {
                especieSelect.val(null).trigger('change');
            }
            $('#tipo_numero_individuos').val(data.tipo_numero_individuos || '');
            $('#numero_individuos').val(data.numero_individuos || '');
            $('#tipo_peso').val(data.tipo_peso || '');
            $('#peso_estimado').val(data.peso_estimado || '');
            $('#estado_producto').val(data.estado_producto || '');
            $('#es_incidental').val(data.es_incidental === undefined || data.es_incidental === null ? '' : (data.es_incidental ? '1' : '0'));
            $('#es_descartada').val(data.es_descartada === undefined || data.es_descartada === null ? '' : (data.es_descartada ? '1' : '0'));

            const promises = [];
            if (data.id) {
                promises.push(
                    fetch(`${ajaxBase}/sitios-pesca?captura_id=${data.id}`)
                        .then(r => r.ok ? r.json() : [])
                        .then(sitios => {
                            let s = sitios.length ? sitios[0] : {};
                            $('#sitio-pesca-id').val(s.id || '');
                            $('#sitio-id').val(s.sitio_id || '');
                            $('#sitio-nombre').val(s.nombre || '');
                            $('#sitio-profundidad').val(s.profundidad || '');
                            $('#sitio-unidad-profundidad').val(s.unidad_profundidad_id || '');
                            $('#sitio-latitud').val(s.latitud || '');
                            $('#sitio-longitud').val(s.longitud || '');
                            return Promise.all([
                                cargarUnidadesProfundidad(s.unidad_profundidad_id || ''),
                                cargarSitios(s.sitio_id || '')
                            ]);
                        })
                        .catch(() => Promise.all([cargarUnidadesProfundidad(''), cargarSitios('')]))
                );

                promises.push(
                    fetch(`${ajaxBase}/artes-pesca?captura_id=${data.id}`)
                        .then(r => r.ok ? r.json() : [])
                        .then(artes => {
                            let a = artes.length ? artes[0] : {};
                            $('#arte-pesca-id').val(a.id || '');
                            $('#lineas-madre').val(a.lineas_madre || '');
                            $('#anzuelos').val(a.anzuelos || '');
                            $('#tamanio-anzuelo-pulg').val(a.tamanio_anzuelo_pulg || '');
                            $('#largo-red-m').val(a.largo_red_m || '');
                            $('#alto-red-m').val(a.alto_red_m || '');
                            $('#ojo-malla-cm').val(a.ojo_malla_cm || '');
                            $('#diametro').val(a.diametro || '');
                            $('#especie-carnada').val(a.especiecarnada || '');
                            $('#carnadaviva').val(a.carnadaviva === undefined || a.carnadaviva === null ? '' : (a.carnadaviva ? '1' : '0'));
                            return Promise.all([
                                cargarTiposArte(a.tipo_arte_id || ''),
                                cargarTiposAnzuelo(a.tipo_anzuelo_id || ''),
                                cargarMaterialesMalla(a.material_malla_id || '')
                            ]);
                        })
                        .catch(() => Promise.all([cargarTiposArte(''), cargarTiposAnzuelo(''), cargarMaterialesMalla('')]))
                );

                promises.push(cargarEconomiaVenta(data.id));
                promises.push(cargarDatosBiologicos(data.id));
                promises.push(cargarArchivos(data.id));

                const campos = (data.respuestas_multifinalitaria || []).map(r => ({
                    id: r.tabla_multifinalitaria_id,
                    nombre_pregunta: r.tabla_multifinalitaria_nombre_pregunta || r.nombre_pregunta,
                    tipo_pregunta: r.tabla_multifinalitaria_tipo_pregunta || r.tipo_pregunta,
                    opciones: r.tabla_multifinalitaria_opciones || r.opciones,
                    requerido: r.tabla_multifinalitaria_requerido || r.requerido,
                }));
                renderCamposDinamicosCaptura(campos, data.respuestas_multifinalitaria || []);
            }

            Promise.all(promises).finally(() => {
                $('#captura-form :input').not('[data-card-widget="collapse"]').not('[data-dismiss="modal"]').prop('disabled', true);
                changeArtePesca($('#tipo-arte-id').val());
                $('#captura-modal').one('shown.bs.modal', function () {
                    $('.spinner-overlay').addClass('d-none');
                }).modal('show');
            });
        }

        function verCaptura(id) {
            $('.spinner-overlay').removeClass('d-none');
            $.ajax({
                url: `${ajaxBase}/capturas/${id}`,
                global: false,
                success: data => abrirModal(data),
                error: () => $('.spinner-overlay').addClass('d-none')
            });
        }

        $('#capturas-table').on('click', '.ver-captura', function () { verCaptura($(this).data('id')); });
    });
</script>
@endsection

