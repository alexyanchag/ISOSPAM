@extends('layouts.dashboard')

@section('spinner')
<x-spinner />
@endsection


@section('content')
<form id="viaje-form" method="POST"
    action="{{ isset($viaje) ? route('viajes.update', $viaje['id']) : route('viajes.store') }}">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @csrf
    @if(isset($viaje))
    @method('PUT')
    @endif
    @if(request()->boolean('por_finalizar'))
    <input type="hidden" name="por_finalizar" value="1">
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ isset($viaje) ? 'Editar' : 'Nuevo' }} Viaje</h3>
            <div class="card-tools">
                <button type="submit" class="btn btn-primary">Guardar</button>
                @isset($viaje)
                @if(request()->boolean('por_finalizar'))
                <button type="submit" formaction="{{ route('viajes.por-finalizar.update', $viaje['id']) }}"
                    class="btn btn-warning">Finalizar</button>
                @endif
                @endisset
                <a href="{{ route('viajes.index') }}" class="btn btn-secondary">Cancelar</a>
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
</form>

@isset($viaje)
@if(request()->boolean('por_finalizar'))
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tripulantes ?? [] as $t)
                    <tr>
                        <td>{{ $t['tipo_tripulante_nombre'] ?? '' }}</td>
                        <td>{{ $t['tripulante_nombres'] ?? '' }}</td>
                        <td class="text-right">
                            <button class="btn btn-xs btn-secondary editar-tripulante"
                                data-id="{{ $t['id'] }}">Editar</button>
                            <button class="btn btn-xs btn-danger eliminar-tripulante"
                                data-id="{{ $t['id'] }}">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button id="agregar-tripulante" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
    </div>
</div>

<div class="modal fade" id="tripulante-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="tripulante-form">
                <div class="modal-header">
                    <h5 class="modal-title">Tripulante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="tripulante-id">

                    <div class="form-group">
                        <label>Tipo de Tripulante</label>
                        <select class="form-control" id="tipo_tripulante_id">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Persona</label>
                        <select class="form-control" id="persona_tripulante_idpersona">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($observadores ?? [] as $o)
                    <tr>
                        <td>{{ $o['tipo_observador_descripcion'] ?? '' }}</td>
                        <td>{{ $o['persona_nombres'] ?? '' }}</td>
                        <td class="text-right">
                            <button class="btn btn-xs btn-secondary editar-observador"
                                data-id="{{ $o['id'] }}">Editar</button>
                            <button class="btn btn-xs btn-danger eliminar-observador"
                                data-id="{{ $o['id'] }}">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button id="agregar-observador" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
    </div>
</div>

<div class="modal fade" id="observador-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="observador-form">
                <div class="modal-header">
                    <h5 class="modal-title">Observador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="observador-id">

                    <div class="form-group">
                        <label>Tipo de Observador</label>
                        <select class="form-control" id="tipo_observador_id">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Persona</label>
                        <select class="form-control" id="persona_idpersona">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                            <button class="btn btn-xs btn-secondary editar-captura"
                                data-id="{{ $c['id'] }}">Editar</button>
                            <button class="btn btn-xs btn-danger eliminar-captura"
                                data-id="{{ $c['id'] }}">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button id="agregar-captura" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
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
                                    <div class="form-group col-md-4">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <button type="button" id="btn-geolocalizar" class="btn btn-secondary btn-sm mr-2">Obtener ubicación <i class="fa-solid fa-location-crosshairs"></i></button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <button type="button" id="btn-mapa" class="btn btn-info btn-sm">Seleccionar en mapa <i class="fa-solid fa-map-location-dot"></i></button>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <button id="agregar-dato-biologico" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <button id="agregar-archivo-captura" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="dato-biologico-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="dato-biologico-form">
                <div class="modal-header">
                    <h5 class="modal-title">Dato biológico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dato-biologico-id">
                    <div class="form-group">
                        <label>Unidad longitud</label>
                        <select id="unidad_longitud_id" class="form-control">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Longitud</label>
                        <input type="number" step="any" id="longitud" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Peso</label>
                        <input type="number" step="any" id="peso" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sexo</label>
                        <select id="sexo" class="form-control">
                            <option value="">Seleccione...</option>
                            <option value="M">Macho</option>
                            <option value="H">Hembra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ovada</label>
                        <select id="ovada" class="form-control">
                            <option value="">Seleccione...</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estado desarrollo gonadal</label>
                        <select id="estado_desarrollo_gonadal_id" class="form-control">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="archivo-captura-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="archivo-captura-form">
                <div class="modal-header">
                    <h5 class="modal-title">Archivo de captura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" id="archivo-input" multiple>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cargar</button>
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
                        <th></th>
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
                        <td class="text-right">
                            <button class="btn btn-xs btn-secondary editar-parametro"
                                data-id="{{ $p['id'] }}">Editar</button>
                            <button class="btn btn-xs btn-danger eliminar-parametro"
                                data-id="{{ $p['id'] }}">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button id="agregar-parametro" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
    </div>
</div>

<div class="modal fade" id="parametro-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="parametro-form">
                <div class="modal-header">
                    <h5 class="modal-title">Parámetro Ambiental</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="parametro-id">
                    <div class="form-group">
                        <label>Hora</label>
                        <input type="time" class="form-control" id="hora">
                    </div>
                    <div class="form-group">
                        <label>Sondeo PPT</label>
                        <input type="number" step="any" class="form-control" id="sondeo_ppt">
                    </div>
                    <div class="form-group">
                        <label>TSMP</label>
                        <input type="number" step="any" class="form-control" id="tsmp">
                    </div>
                    <div class="form-group">
                        <label>Estado Marea</label>
                        <select class="form-control" id="estado_marea_id">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Condición Mar</label>
                        <select class="form-control" id="condicion_mar_id">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Oxígeno mg/l</label>
                        <input type="number" step="any" class="form-control" id="oxigeno_mg_l">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($economiaInsumos ?? [] as $e)
                    <tr>
                        <td>{{ $e['nombre_tipo'] ?? '' }}</td>
                        <td>{{ $e['nombre_unidad'] ?? '' }}</td>
                        <td>{{ $e['cantidad'] ?? '' }}</td>
                        <td>{{ $e['precio'] ?? '' }}</td>
                        <td class="text-right">
                            <button class="btn btn-xs btn-secondary editar-economia-insumo"
                                data-id="{{ $e['id'] }}">Editar</button>
                            <button class="btn btn-xs btn-danger eliminar-economia-insumo"
                                data-id="{{ $e['id'] }}">Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button id="agregar-economia-insumo" type="button" class="btn btn-primary btn-xs mt-2">Agregar</button>
    </div>
</div>

<div class="modal fade" id="economia-insumo-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="economia-insumo-form">
                <div class="modal-header">
                    <h5 class="modal-title">Economía de Insumo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="economia-insumo-id">
                    <div class="form-group">
                        <label>Tipo de Insumo <span class="text-danger">*</span></label>
                        <select class="form-control" id="tipo_insumo_id" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Unidad de Insumo <span class="text-danger">*</span></label>
                        <select class="form-control" id="unidad_insumo_id" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad <span class="text-danger">*</span></label>
                        <input type="number" step="any" class="form-control" id="cantidad" required>
                    </div>
                    <div class="form-group">
                        <label>Precio <span class="text-danger">*</span></label>
                        <input type="number" step="any" class="form-control" id="precio_insumo" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mapa-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar ubicación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="mapa-sitio" style="height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardar-mapa">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endif
@endisset
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWFpxWyWOOOfzceN1ycIhCv9hzpeK7nHg"></script>

<script>
    function mostrarErrorCaptura(mensaje) {
        Swal.fire({ icon: 'error', title: 'Error', text: mensaje });
    }

    let tipoArtePesca = '';

    let mapa, marcador;

    function initMap(lat = -12.046374, lng = -77.042793) {
        const centro = { lat, lng };
        mapa = new google.maps.Map(document.getElementById('mapa-sitio'), {
            zoom: 8,
            center: centro
        });
        marcador = new google.maps.Marker({
            position: centro,
            map: mapa,
            draggable: true
        });
    }

    $(function () {
        // Validación de fechas y horas de zarpe y arribo
        const fechaZarpe = document.getElementById('fecha_zarpe');
        const fechaArribo = document.getElementById('fecha_arribo');
        const horaZarpe = document.getElementById('hora_zarpe');
        const horaArribo = document.getElementById('hora_arribo');
        const form = document.getElementById('viaje-form');

        function actualizarRestricciones() {
            if (fechaArribo.value) {
                fechaZarpe.max = fechaArribo.value;
            } else {
                fechaZarpe.removeAttribute('max');
            }
            if (fechaZarpe.value) {
                fechaArribo.min = fechaZarpe.value;
            } else {
                fechaArribo.removeAttribute('min');
            }

            if (fechaZarpe.value && fechaArribo.value && fechaZarpe.value === fechaArribo.value) {
                if (horaArribo.value) {
                    horaZarpe.max = horaArribo.value;
                } else {
                    horaZarpe.removeAttribute('max');
                }
                if (horaZarpe.value) {
                    horaArribo.min = horaZarpe.value;
                } else {
                    horaArribo.removeAttribute('min');
                }
            } else {
                horaZarpe.removeAttribute('max');
                horaArribo.removeAttribute('min');
            }
        }

        fechaZarpe.addEventListener('change', actualizarRestricciones);
        fechaArribo.addEventListener('change', actualizarRestricciones);
        horaZarpe.addEventListener('change', actualizarRestricciones);
        horaArribo.addEventListener('change', actualizarRestricciones);
        form.addEventListener('submit', function (e) {
            if (fechaZarpe.value && fechaArribo.value) {
                if (fechaZarpe.value > fechaArribo.value) {
                    e.preventDefault();
                    alert('La fecha de arribo debe ser mayor o igual a la fecha de zarpe.');
                    return;
                }
                if (fechaZarpe.value === fechaArribo.value && horaZarpe.value && horaArribo.value && horaZarpe.value >= horaArribo.value) {
                    e.preventDefault();
                    alert('La hora de arribo debe ser mayor que la hora de zarpe cuando las fechas son iguales.');
                }
            }
        });

        actualizarRestricciones();

        // Evitar números negativos tanto al escribir como con las flechas
        $('.no-negative')
            .on('keydown', function (e) {
                if (e.key === '-' || e.key === '+') {
                    e.preventDefault();
                }
            })
            .on('input', function () {
                this.value = this.value.replace(/-/g, '');
            });

        $('#responsable-select').select2({
            width: '100%',
            placeholder: 'Seleccione...',
            allowClear: true,
            ajax: {
                url: "{{ route('ajax.personas') }}",
                dataType: 'json',
                delay: 250,
                data: params => ({ filtro: params.term, rol: 'RESPVJ' }),
                processResults: data => ({
                    results: $.map(data, p => ({ id: p.idpersona, text: `${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim() }))
                }),
                cache: true
            }
        });

        $('#digitador-select').select2({
            width: '100%',
            placeholder: 'Seleccione...',
            allowClear: true,
            ajax: {
                url: "{{ route('ajax.personas') }}",
                dataType: 'json',
                delay: 250,
                data: params => ({ filtro: params.term, rol: 'CTF' }),
                processResults: data => ({
                    results: $.map(data, p => ({ id: p.idpersona, text: `${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim() }))
                }),
                cache: true
            }
        });

        $('#persona_idpersona').select2({
            width: '100%',
            dropdownParent: $('#observador-modal'),
            placeholder: 'Seleccione...',
            allowClear: true,
            ajax: {
                url: "{{ route('ajax.personas') }}",
                dataType: 'json',
                delay: 250,
                data: params => ({ filtro: params.term, rol: 'OBS' }),
                processResults: data => ({
                    results: $.map(data, p => ({ id: p.idpersona, text: `${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim() }))
                }),
                cache: true
            }
        });

        $('#persona_tripulante_idpersona').select2({
            width: '100%',
            dropdownParent: $('#tripulante-modal'),
            placeholder: 'Seleccione...',
            allowClear: true,
            ajax: {
                url: "{{ route('ajax.personas') }}",
                dataType: 'json',
                delay: 250,
                data: params => ({ filtro: params.term, rol: 'TRIPVJ' }),
                processResults: data => ({
                    results: $.map(data, p => ({ id: p.idpersona, text: `${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim() }))
                }),
                cache: true
            }
        });
        function renderCamposDinamicos(campos) {
            const row = $('#campos-dinamicos-body .row');
            row.empty();
            if (!campos.length) {
                row.append('<p class="col-12 mb-0">No hay campos dinámicos para la campaña seleccionada.</p>');
                return;
            }
            campos.forEach(function (campo, index) {
                var control = '';
                var requerido = campo.requerido ? 'required' : '';
                var asterisk = campo.requerido ? ' <span class="text-danger">*</span>' : '';
                switch (campo.tipo_pregunta) {
                    case 'COMBO':
                        var opciones = [];
                        try { opciones = JSON.parse(campo.opciones || '[]'); } catch (e) { }
                        control = '<select class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + index + '][respuesta]"><option value="">Seleccione...</option>';
                        opciones.forEach(function (opt) {
                            var value = (typeof opt === 'object') ? (opt.valor || '') : String(opt);
                            var text = (typeof opt === 'object') ? (opt.texto || '') : String(opt);
                            control += '<option value="' + value + '">' + text + '</option>';
                        });
                        control += '</select>';
                        break;
                    case 'INTEGER':
                        control = '<input type="number" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + index + '][respuesta]">';
                        break;
                    case 'DATE':
                        control = '<input type="date" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + index + '][respuesta]">';
                        break;
                    case 'TIME':
                        control = '<input type="time" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + index + '][respuesta]">';
                        break;
                    default:
                        control = '<input type="text" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + index + '][respuesta]">';
                }
                var tablaId = campo.id != null ? campo.id : 0;
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + index + '][tabla_multifinalitaria_id]" value="' + tablaId + '">';
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + index + '][id]" value="0">';
                var col = $('<div class="col-md-4 mb-3"></div>');
                col.append('<label class="form-label">' + (campo.nombre_pregunta || '') + asterisk + '</label>');
                col.append(control);
                row.append(col);
            });
        }

        function renderCamposDinamicosCaptura(campos = [], respuestas = []) {
            console.log(campos)
            const row = $('#campos-dinamicos-captura');
            row.empty();
            if (!campos.length) {
                row.append('<p class="col-12 mb-0">No hay campos dinámicos para la campaña seleccionada.</p>');
                return;
            }
            const respMap = {};
            (respuestas || []).forEach(r => {
                respMap[r.tabla_multifinalitaria_id] = r;
            });
            campos.forEach(function (campo, index) {
                var control = '';
                var requerido = campo.requerido ? 'required' : '';
                var asterisk = campo.requerido ? ' <span class="text-danger">*</span>' : '';
                var resp = respMap[campo.id] || {};
                var key = campo.id != null ? campo.id : index;
                switch (campo.tipo_pregunta) {
                    case 'COMBO':
                        var opciones = [];
                        try { opciones = JSON.parse(campo.opciones || '[]'); } catch (e) { }
                        control = '<select class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + key + '][respuesta]"><option value="">Seleccione...</option>';
                        opciones.forEach(function (opt) {
                            var value = (typeof opt === 'object') ? (opt.valor || '') : String(opt);
                            var text = (typeof opt === 'object') ? (opt.texto || '') : String(opt);
                            var selected = (resp.respuesta || '') == value ? ' selected' : '';
                            control += '<option value="' + value + '"' + selected + '>' + text + '</option>';
                        });
                        control += '</select>';
                        break;
                    case 'INTEGER':
                        control = '<input type="number" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '">';
                        break;
                    case 'DATE':
                        control = '<input type="date" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '">';
                        break;
                    case 'TIME':
                        control = '<input type="time" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '">';
                        break;
                    default:
                        control = '<input type="text" class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + key + '][respuesta]" value="' + (resp.respuesta || '') + '">';
                }
                var tablaId = campo.id != null ? parseInt(campo.id) : parseInt(campo.tabla_multifinalitaria_id);
                var respId = resp.id != null ? resp.id : 0;
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + key + '][tabla_multifinalitaria_id]" value="' + tablaId + '">';
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + key + '][id]" value="' + respId + '">';
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + key + '][campania_id]" value="' + campo.campania_id + '">';
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + key + '][tabla_relacionada]" value="' + campo.tabla_relacionada + '">';
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + key + '][nombre_pregunta]" value="' + campo.nombre_pregunta + '">';
                control += '<input type="hidden" name="respuestas_multifinalitaria[' + key + '][tipo_pregunta]" value="' + campo.tipo_pregunta + '">';
                var col = $('<div class="col-md-4 mb-3"></div>');
                col.append('<label class="form-label">' + (campo.nombre_pregunta || '') + asterisk + '</label>');
                col.append(control);
                row.append(col);
            });
        }

        $('select[name="campania_id"]').on('change', function () {
            var campaniaId = $(this).val();
            if (!campaniaId) {
                renderCamposDinamicos([]);
                return;
            }
            $.get("{{ url('ajax/campos-dinamicos') }}", { campania_id: campaniaId, tabla_relacionada: 'viaje' }, function (data) {
                renderCamposDinamicos(data);
            });
        });

        const ajaxBase = "{{ url('ajax') }}";
        const viajeId = "{{ $viaje['id'] ?? 'null' }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function cargarEspecies(selected = '') {
            const select = $('#especie_id');
            select.empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.especies') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(e => {
                        const opt = new Option(e.nombre, e.id, false, String(e.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar especies:', err));
        }

        function cargarTiposObservador(selected = '') {
            const select = $('#tipo_observador_id');
            select.empty().append('<option value="">Seleccione...</option>');
            fetch("{{ route('api.tipo-observador') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.descripcion, t.id, false, String(t.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar tipos de observador:', err));
        }

        function cargarTiposTripulante(selected = '') {
            const select = $('#tipo_tripulante_id');
            select.empty().append('<option value="">Seleccione...</option>');
            fetch("{{ route('api.tipos-tripulante') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.descripcion, t.id, false, String(t.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar tipos de tripulante:', err));
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
                })
                .catch(err => console.error('Error al cargar unidades de profundidad:', err));
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
                })
                .catch(err => console.error('Error al cargar sitios:', err));
        }

        $('#sitio-id').on('change', function () {
            const id = $(this).val();
            const s = sitiosCache.find(x => String(x.id) === String(id));
            if (s) {
                $('#sitio-nombre').val(s.nombre || '');
                $('#sitio-latitud').val(s.latitud || '');
                $('#sitio-longitud').val(s.longitud || '');
                $('#sitio-profundidad').val(s.profundidad || '');
                $('#sitio-unidad-profundidad').val(s.unidad_profundidad_id || '');
            } else {
                $('#sitio-nombre').val('');
                $('#sitio-latitud').val('');
                $('#sitio-longitud').val('');
                $('#sitio-profundidad').val('');
                $('#sitio-unidad-profundidad').val('');
            }
        });

        function cargarTiposArte(selected = '') {
            const select = $('#tipo-arte-id');
            select.empty().append('<option value="">Seleccione...</option>');
            return new Promise((resolve, reject) => {
                fetch("{{ route('api.tipos-arte') }}")
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(t => {
                            const opt = new Option(t.nombre || t.descripcion || '', t.id, false, String(t.id) === String(selected));
                            if (t.tipo !== undefined && t.tipo !== null) {
                                opt.dataset.tipo = t.tipo;
                            }
                            select.append(opt);
                        });
                        select.val(selected);
                        resolve(selected);
                    })
                    .catch(err => {
                        console.error('Error al cargar tipos de arte:', err);
                        reject(err);
                    });
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
                })
                .catch(err => console.error('Error al cargar tipos de anzuelo:', err));
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
                })
                .catch(err => console.error('Error al cargar materiales de malla:', err));
        }

        function cargarTripulantes() {
            $.ajax({
                url: `${ajaxBase}/tripulantes-viaje`,
                data: { viaje_id: viajeId },
                success: data => {
                    const tbody = $('#tripulantes-table tbody').empty();
                    data.forEach(t => {
                        const row = `<tr>
                                <td>${t.tipo_tripulante_nombre ?? ''}</td>
                                <td>${t.tripulante_nombres ?? ''}</td>
                                <td class=\"text-right\">
                                    <button class=\"btn btn-xs btn-secondary editar-tripulante\" data-id=\"${t.id}\">Editar</button>
                                    <button class=\"btn btn-xs btn-danger eliminar-tripulante\" data-id=\"${t.id}\">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                }
            });
        }

        function cargarCapturas() {
            $.ajax({
                url: `${ajaxBase}/capturas-viaje`,
                data: { viaje_id: viajeId },
                success: data => {
                    const tbody = $('#capturas-table tbody').empty();
                    data.forEach(c => {
                        const row = `<tr>
                                <td>${c.nombre_comun ?? ''}</td>
                                <td>${c.especie_nombre ?? ''}</td>
                                <td>${c.numero_individuos ?? ''}</td>
                                <td>${c.peso_estimado ?? ''}</td>
                                <td>${c.peso_contado ?? ''}</td>
                                <td>${c.es_incidental ? 'Sí' : 'No'}</td>
                                <td>${c.es_descartada ? 'Sí' : 'No'}</td>
                                <td>${c.tipo_numero_individuos ?? ''}</td>
                                <td>${c.tipo_peso ?? ''}</td>
                                <td>${c.estado_producto ?? ''}</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-secondary editar-captura" data-id="${c.id}">Editar</button>
                                    <button class="btn btn-xs btn-danger eliminar-captura" data-id="${c.id}">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                }
            });
        }

        function cargarObservadores() {
            $.ajax({
                url: `${ajaxBase}/observadores-viaje`,
                data: { viaje_id: viajeId },
                success: data => {
                    const tbody = $('#observadores-table tbody').empty();
                    data.forEach(o => {
                        const row = `<tr>
                                <td>${o.tipo_observador_descripcion ?? ''}</td>
                                <td>${o.persona_nombres ?? ''}</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-secondary editar-observador" data-id="${o.id}">Editar</button>
                                    <button class="btn btn-xs btn-danger eliminar-observador" data-id="${o.id}">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                }
            });
        }

        function cargarEstadosMarea(selected = '') {
            const select = $('#estado_marea_id');
            select.empty().append('<option value="">Seleccione...</option>');
            fetch("{{ route('api.estados-marea') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(e => {
                        const opt = new Option(e.descripcion, e.id, false, String(e.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar estados de marea:', err));
        }

        function cargarCondicionesMar(selected = '') {
            const select = $('#condicion_mar_id');
            select.empty().append('<option value="">Seleccione...</option>');
            fetch("{{ route('api.condiciones-mar') }}")
                .then(response => response.json())
                .then(data => {
                    data.forEach(c => {
                        const opt = new Option(c.descripcion, c.id, false, String(c.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar condiciones de mar:', err));
        }

        function cargarParametrosAmbientales() {
            $.ajax({
                url: `${ajaxBase}/parametros-ambientales`,
                data: { viaje_id: viajeId },
                success: data => {
                    const tbody = $('#parametros-ambientales-table tbody').empty();
                    data.forEach(p => {
                        const row = `<tr>
                                <td>${p.hora ?? ''}</td>
                                <td>${p.sondeo_ppt ?? ''}</td>
                                <td>${p.tsmp ?? ''}</td>
                                <td>${p.estado_marea_descripcion ?? ''}</td>
                                <td>${p.condicion_mar_descripcion ?? ''}</td>
                                <td>${p.oxigeno_mg_l ?? ''}</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-secondary editar-parametro" data-id="${p.id}">Editar</button>
                                    <button class="btn btn-xs btn-danger eliminar-parametro" data-id="${p.id}">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                }
            });
        }

        function abrirParametroModal(data = {}) {
            $('#parametro-id').val(data.id || '');
            $('#hora').val(data.hora || '');
            $('#sondeo_ppt').val(data.sondeo_ppt || '');
            $('#tsmp').val(data.tsmp || '');
            cargarEstadosMarea(data.estado_marea_id || '');
            cargarCondicionesMar(data.condicion_mar_id || '');
            $('#oxigeno_mg_l').val(data.oxigeno_mg_l || '');
            $('#parametro-modal').modal('show');
        }

        function editarParametro(id) {
            $.ajax({
                url: `${ajaxBase}/parametros-ambientales/${id}`,
                success: data => abrirParametroModal(data)
            });
        }

        function eliminarParametro(id) {
            if (!confirm('¿Eliminar parámetro?')) return;
            $.ajax({
                url: `${ajaxBase}/parametros-ambientales/${id}`,
                method: 'DELETE',
                success: cargarParametrosAmbientales
            });
        }

        function cargarEconomiaInsumo() {
            $.ajax({
                url: `${ajaxBase}/economia-insumo`,
                data: { viaje_id: viajeId },
                success: data => {
                    const tbody = $('#economia-insumo-table tbody').empty();
                    data.forEach(e => {
                        const row = `<tr>
                                <td>${e.nombre_tipo ?? ''}</td>
                                <td>${e.nombre_unidad ?? ''}</td>
                                <td>${e.cantidad ?? ''}</td>
                                <td>${e.precio ?? ''}</td>
                                <td class="text-right">
                                    <button class=\"btn btn-xs btn-secondary editar-economia-insumo\" data-id=\"${e.id}\">Editar</button>
                                    <button class=\"btn btn-xs btn-danger eliminar-economia-insumo\" data-id=\"${e.id}\">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                }
            });
        }

        function cargarTiposInsumo(selected = '') {
            const select = $('#tipo_insumo_id').empty().append('<option value="">Seleccione...</option>');
            fetch("{{ route('api.tipos-insumo') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(t => {
                        const opt = new Option(t.nombre, t.id, false, String(t.id) === String(selected));
                        select.append(opt);
                    });
                });
        }

        function cargarUnidadesInsumo(selected = '') {
            const select = $('#unidad_insumo_id').empty().append('<option value="">Seleccione...</option>');
            fetch("{{ route('api.unidades-insumo') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(u => {
                        const opt = new Option(u.nombre, u.id, false, String(u.id) === String(selected));
                        select.append(opt);
                    });
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
                })
                .catch(err => console.error('Error al cargar unidades de venta:', err));
        }

        function cargarEconomiaVenta(capturaId) {
            return fetch(`${ajaxBase}/economia-ventas?captura_id=${capturaId}`)
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(data => {
                    const ev = Array.isArray(data) && data.length ? data[0] : null;
                    $('#economia-venta-id').val(ev?.id || '');
                    $('#vendido-a').val(ev?.vendido_a || '');
                    $('#destino').val(ev?.destino || '');
                    $('#precio').val(ev?.precio || '');
                    return cargarUnidadesVenta(ev?.unidad_venta_id || '');
                })
                .catch(err => {
                    console.error('Error al cargar dato económico:', err);
                    $('#economia-venta-id').val('');
                    $('#vendido-a').val('');
                    $('#destino').val('');
                    $('#precio').val('');
                    return cargarUnidadesVenta('');
                });
        }

        function abrirEconomiaInsumoModal(data = {}) {
            $('#economia-insumo-id').val(data.id || '');
            $('#cantidad').val(data.cantidad || '');
            $('#precio_insumo').val(data.precio || '');
            cargarTiposInsumo(data.tipo_insumo_id || '');
            cargarUnidadesInsumo(data.unidad_insumo_id || '');
            $('#economia-insumo-modal').modal('show');
        }

        function editarEconomiaInsumo(id) {
            $.ajax({
                url: `${ajaxBase}/economia-insumo/${id}`,
                success: data => abrirEconomiaInsumoModal(data)
            });
        }

        function eliminarEconomiaInsumo(id) {
            if (!confirm('¿Eliminar insumo?')) return;
            $.ajax({
                url: `${ajaxBase}/economia-insumo/${id}`,
                method: 'DELETE',
                success: cargarEconomiaInsumo
            });
        }

        $('#economia-insumo-form').on('submit', function (e) {
            e.preventDefault();
            const id = $('#economia-insumo-id').val();
            const payload = {
                viaje_id: viajeId,
                tipo_insumo_id: $('#tipo_insumo_id').val(),
                unidad_insumo_id: $('#unidad_insumo_id').val(),
                cantidad: $('#cantidad').val(),
                precio: $('#precio_insumo').val()
            };
            const url = id ? `${ajaxBase}/economia-insumo/${id}` : `${ajaxBase}/economia-insumo`;
            const method = id ? 'PUT' : 'POST';
            $.ajax({
                url: url,
                method: method,
                data: payload,
                success: () => {
                    $('#economia-insumo-modal').modal('hide');
                    cargarEconomiaInsumo();
                }
            });
        });

        function cargarUnidadesLongitud(selected = '') {
            const select = $('#unidad_longitud_id').empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.unidades-longitud') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(u => {
                        const opt = new Option(u.nombre || u.descripcion || '', u.id, false, String(u.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar unidades de longitud:', err));
        }

        function cargarEstadosDesarrolloGonadal(selected = '') {
            const select = $('#estado_desarrollo_gonadal_id').empty().append('<option value="">Seleccione...</option>');
            return fetch("{{ route('api.estados-desarrollo-gonadal') }}")
                .then(r => r.json())
                .then(data => {
                    data.forEach(e => {
                        const opt = new Option(e.descripcion || e.nombre || '', e.id, false, String(e.id) === String(selected));
                        select.append(opt);
                    });
                })
                .catch(err => console.error('Error al cargar estados de desarrollo gonadal:', err));
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
                        const row = `<tr data-id="${d.id}">
                                <td>${d.longitud ?? ''}</td>
                                <td>${d.peso ?? ''}</td>
                                <td>${d.sexo ?? ''}</td>
                                <td>${d.ovada ? 'Sí' : 'No'}</td>
                                <td>${d.estado_desarrollo_gonadal_descripcion ?? ''}</td>
                                <td class=\"text-right\">
                                    <button type=\"button\" class=\"btn btn-xs btn-secondary editar-dato-biologico\" data-id=\"${d.id}\">Editar</button>
                                    <button type=\"button\" class=\"btn btn-xs btn-danger eliminar-dato-biologico\" data-id=\"${d.id}\">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                })
                .catch(err => {
                    console.error('Error al cargar datos biológicos:', err);
                    $('#datos-biologicos-table tbody').empty();
                });
        }

        function abrirDatoBiologicoModal(data = {}) {
            $('#dato-biologico-id').val(data.id || '');
            $('#longitud').val(data.longitud || '');
            $('#peso').val(data.peso || '');
            $('#sexo').val(data.sexo || '');
            $('#ovada').val(data.ovada === undefined || data.ovada === null ? '' : (data.ovada ? '1' : '0'));
            cargarUnidadesLongitud(data.unidad_longitud_id || '');
            cargarEstadosDesarrolloGonadal(data.estado_desarrollo_gonadal_id || '');
            $('#dato-biologico-modal').modal('show');
        }

        function editarDatoBiologico(id) {
            const row = $(`#datos-biologicos-table tbody tr[data-id="${id}"]`);
            if (row.data('pending')) {
                const item = row.data('item');
                abrirDatoBiologicoModal(Object.assign({ id }, item));
                return;
            }
            $.ajax({
                url: `${ajaxBase}/datos-biologicos/${id}`,
                success: data => abrirDatoBiologicoModal(data)
            });
        }

        function eliminarDatoBiologico(id) {
            const row = $(`#datos-biologicos-table tbody tr[data-id="${id}"]`);
            if (row.data('pending')) {
                row.remove();
                return;
            }
            if (!confirm('¿Eliminar dato biológico?')) return;
            $.ajax({
                url: `${ajaxBase}/datos-biologicos/${id}`,
                method: 'DELETE',
                success: () => cargarDatosBiologicos($('#captura-id').val())
            });
        }

        $('#dato-biologico-form').on('submit', async function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('.spinner-overlay').removeClass('d-none');
            try {
                const id = $('#dato-biologico-id').val();
                const capturaId = $('#captura-id').val();
                const payload = {
                    id: id ? parseInt(id) : null,
                    unidad_longitud_id: $('#unidad_longitud_id').val(),
                    longitud: $('#longitud').val(),
                    peso: $('#peso').val(),
                    sexo: $('#sexo').val(),
                    ovada: $('#ovada').val() === '1',
                    estado_desarrollo_gonadal_id: $('#estado_desarrollo_gonadal_id').val() ? $('#estado_desarrollo_gonadal_id').val() : null,
                };
                if (capturaId) {
                    payload.captura_id = capturaId;
                    const url = id ? `${ajaxBase}/datos-biologicos/${id}` : `${ajaxBase}/datos-biologicos`;
                    const method = id ? 'PUT' : 'POST';
                    console.log(payload)
                    const resp = await fetch(url, {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(payload)
                    });
                    if (resp.ok) {
                        $('#dato-biologico-modal').modal('hide');
                        cargarDatosBiologicos(capturaId);
                    } else {
                        alert('Error al guardar dato biológico');
                    }
                    return;
                }

                const rowId = id || `tmp-${Date.now()}`;
                const row = `<tr data-id="${rowId}" data-pending="1">
                        <td>${payload.longitud || ''}</td>
                        <td>${payload.peso || ''}</td>
                        <td>${payload.sexo || ''}</td>
                        <td>${payload.ovada ? 'Sí' : 'No'}</td>
                        <td>${$('#estado_desarrollo_gonadal_id option:selected').text()}</td>
                        <td class="text-right">
                            <button class="btn btn-xs btn-secondary editar-dato-biologico" data-id="${rowId}">Editar</button>
                            <button class="btn btn-xs btn-danger eliminar-dato-biologico" data-id="${rowId}">Eliminar</button>
                        </td>
                    </tr>`;
                const tbody = $('#datos-biologicos-table tbody');
                const existing = tbody.find(`tr[data-id="${id}"]`);
                if (existing.length) {
                    existing.replaceWith(row);
                } else {
                    tbody.append(row);
                }
                tbody.find(`tr[data-id="${rowId}"]`).data('pending', true).data('item', payload);
                $('#dato-biologico-modal').modal('hide');
            } finally {
                $('.spinner-overlay').addClass('d-none');
            }
        });

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
                        const row = `<tr data-id="${a.id}">
                                <td><a href="${a.url}" target="_blank">${a.nombre_original}</a></td>
                                <td>${a.tamano ?? ''}</td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-xs btn-danger eliminar-archivo-captura" data-id="${a.id}">Eliminar</button>
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });
                })
                .catch(err => {
                    console.error('Error al cargar archivos:', err);
                    $('#archivos-captura-table tbody').empty();
                });
        }

        function abrirArchivoCapturaModal() {
            $('#archivo-input').val('');
            $('#archivo-captura-modal').modal('show');
        }

        function eliminarArchivoCaptura(id) {
            const row = $(`#archivos-captura-table tbody tr[data-id="${id}"]`);
            if (row.data('pending')) {
                row.remove();
                if (!$('#captura-id').val() && !$('#archivos-captura-table tbody tr').length) {
                    $('#archivo-captura-card').hide();
                }
                return;
            }
            if (!confirm('¿Eliminar archivo?')) return;
            fetch(`/ajax/archivos/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                credentials: 'same-origin'
            }).then(() => cargarArchivos($('#captura-id').val()));
        }

        $('#archivo-captura-form').on('submit', async function (e) {
            e.preventDefault();
            $('.spinner-overlay').removeClass('d-none');
            try {
                const capturaId = $('#captura-id').val();
                const files = $('#archivo-input')[0].files;
                if (!files.length) {
                    $('#archivo-captura-modal').modal('hide');
                    $('.spinner-overlay').addClass('d-none');
                    return;
                }
                if (capturaId) {
                    const formData = new FormData();
                    Array.from(files).forEach(f => formData.append('archivos[]', f));
                    const r = await fetch(`/ajax/capturas/${capturaId}/archivos`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: formData,
                        credentials: 'same-origin'
                    });
                    if (r.ok) {
                        $('#archivo-captura-modal').modal('hide');
                        await cargarArchivos(capturaId);
                        Swal.fire({icon:'success', title:'Éxito', text:'Archivo subido correctamente'});
                    } else {
                        Swal.fire({icon:'error', title:'Error', text:'Error al subir archivo'});
                    }
                    $('.spinner-overlay').addClass('d-none');
                    return;
                }
                const tbody = $('#archivos-captura-table tbody');
                Array.from(files).forEach(f => {
                    const rowId = `tmp-${Date.now()}-${Math.random().toString(36).slice(2)}`;
                    const url = URL.createObjectURL(f);
                    const row = `<tr data-id="${rowId}" data-pending="1">
                            <td><a href="${url}" target="_blank">${f.name}</a></td>
                            <td>${f.size}</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-xs btn-danger eliminar-archivo-captura" data-id="${rowId}">Eliminar</button>
                            </td>
                        </tr>`;
                    tbody.append(row);
                    tbody.find(`tr[data-id="${rowId}"]`).data('pending', true).data('file', f);
                });
                $('#archivo-captura-card').removeClass('d-none').show();
                $('#archivo-captura-modal').modal('hide');
            } catch (err) {
                mostrarErrorCaptura('Error de red al subir archivo');
            } finally {
                $('.spinner-overlay').addClass('d-none');
            }
        });

        function mostrarTodasLasCards() {
            ['#sitio-pesca-card', '#arte-pesca-card', '#economia-venta-card', '#dato-biologico-card', '#archivo-captura-card']
                .forEach(id => {
                    const card = $(id);
                    card.removeClass('d-none');
                    if (typeof card.CardWidget === 'function') {
                        card.CardWidget('expand'); // Expande el cuerpo de la card
                    } else {
                        card.removeClass('collapsed-card').find('.card-body').show();
                    }
                });
        }

        function abrirModal(data = {}) {
            mostrarTodasLasCards();
            $('.spinner-overlay').removeClass('d-none');
            const campaniaId = $('select[name="campania_id"]').val();
            const promises = [];
            $('#captura-id').val(data.id || '');
            $('#nombre_comun').val(data.nombre_comun || '');
            promises.push(cargarEspecies(data.especie_id || ''));
            $('#numero_individuos').val(data.numero_individuos || '');
            $('#peso_estimado').val(data.peso_estimado || '');
            $('#peso_contado').val(data.peso_contado || '');
            const incVal =
                data.es_incidental === undefined || data.es_incidental === null
                    ? ''
                    : data.es_incidental ? '1' : '0';
            $('#es_incidental').val(incVal);
            const descVal =
                data.es_descartada === undefined || data.es_descartada === null
                    ? ''
                    : data.es_descartada ? '1' : '0';
            $('#es_descartada').val(descVal);
            $('#tipo_numero_individuos').val(data.tipo_numero_individuos || '');
            $('#tipo_peso').val(data.tipo_peso || '');
            $('#estado_producto').val(data.estado_producto || '');
            renderCamposDinamicosCaptura([]);

            const sitioRegistroId = $('#sitio-pesca-id');
            const sitioId = $('#sitio-id');
            const sitioNombre = $('#sitio-nombre');
            const sitioLatitud = $('#sitio-latitud');
            const sitioLongitud = $('#sitio-longitud');
            const sitioProfundidad = $('#sitio-profundidad');
            const sitioUnidad = $('#sitio-unidad-profundidad');

            sitioRegistroId.val('');
            sitioId.val('');
            sitioNombre.val('');
            sitioLatitud.val('');
            sitioLongitud.val('');
            sitioProfundidad.val('');
            sitioUnidad.val('');

            $('#arte-pesca-id').val('');
            $('#tipo-arte-id').val('');
            $('#lineas-madre').val('');
            $('#anzuelos').val('');
            $('#tamanio-anzuelo-pulg').val('');
            $('#tipo-anzuelo-id').val('');
            $('#largo-red-m').val('');
            $('#alto-red-m').val('');
            $('#material-malla-id').val('');
            $('#ojo-malla-cm').val('');
            $('#diametro').val('');
            $('#carnadaviva').val('');
            $('#especie-carnada').val('');

            $('#economia-venta-id').val('');
            $('#vendido-a').val('');
            $('#destino').val('');
            $('#precio').val('');
            $('#unidad-venta-id').val('');

            $('#datos-biologicos-table tbody').empty();

            const archivoCard = $('#archivo-captura-card');
            $('#archivos-captura-table tbody').empty();
            if (data.id) {
                archivoCard.show();
                promises.push(cargarArchivos(data.id));
            } else {
                archivoCard.hide();
            }

            if (data.id) {
                promises.push(
                    fetch(`${ajaxBase}/sitios-pesca?captura_id=${data.id}`)
                        .then(r => r.ok ? r.json() : Promise.reject(r))
                        .then(sitios => {
                            let unidadId = '';
                            let sitioSeleccionado = '';
                            if (Array.isArray(sitios) && sitios.length > 0) {
                                const s = sitios[0];
                                sitioRegistroId.val(s.id || '');
                                sitioId.val(s.sitio_id || '');
                                sitioNombre.val(s.nombre || '');
                                sitioLatitud.val(s.latitud || '');
                                sitioLongitud.val(s.longitud || '');
                                sitioProfundidad.val(s.profundidad || '');
                                unidadId = s.unidad_profundidad_id || '';
                                sitioSeleccionado = s.sitio_id || '';
                            }
                            return Promise.all([
                                cargarUnidadesProfundidad(unidadId),
                                cargarSitios(sitioSeleccionado)
                            ]);
                        })
                        .catch(err => {
                            console.error('Error al cargar sitio de pesca:', err);
                            alert('Error al cargar sitio de pesca');
                            return Promise.all([
                                cargarUnidadesProfundidad(''),
                                cargarSitios('')
                            ]);
                        })
                );

                promises.push(
                    fetch(`${ajaxBase}/artes-pesca?captura_id=${data.id}`)
                        .then(r => r.ok ? r.json() : [])
                        .then(artes => {
                            let tipoArteSel = '';
                            let tipoAnzueloSel = '';
                            let materialMallaSel = '';
                            if (Array.isArray(artes) && artes.length) {
                                const a = artes[0];
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
                                tipoArteSel = a.tipo_arte_id || '';
                                tipoAnzueloSel = a.tipo_anzuelo_id || '';
                                materialMallaSel = a.material_malla_id || '';
                            }
                            return Promise.all([
                                cargarTiposArte(tipoArteSel),
                                cargarTiposAnzuelo(tipoAnzueloSel),
                                cargarMaterialesMalla(materialMallaSel)
                            ]);
                        })
                        .catch(err => {
                            console.error('Error al cargar arte de pesca:', err);
                            $('#arte-pesca-id').val('');
                            $('#lineas-madre').val('');
                            $('#anzuelos').val('');
                            $('#tamanio-anzuelo-pulg').val('');
                            $('#largo-red-m').val('');
                            $('#alto-red-m').val('');
                            $('#ojo-malla-cm').val('');
                            $('#diametro').val('');
                            $('#especie-carnada').val('');
                            $('#carnadaviva').val('');
                            return Promise.all([
                                cargarTiposArte(''),
                                cargarTiposAnzuelo(''),
                                cargarMaterialesMalla('')
                            ]);
                        })
                );

                promises.push(cargarEconomiaVenta(data.id));
                promises.push(cargarDatosBiologicos(data.id));
            } else {
                promises.push(
                    cargarUnidadesProfundidad(''),
                    cargarSitios(''),
                    cargarTiposArte(''),
                    cargarTiposAnzuelo(''),
                    cargarMaterialesMalla(''),
                    cargarUnidadesVenta('')
                );
            }
            if (data.id) {
                const campos = (data.respuestas_multifinalitaria || []).map(r => ({
                    id: r.tabla_multifinalitaria_id,
                    nombre_pregunta: r.tabla_multifinalitaria_nombre_pregunta || r.nombre_pregunta,
                    tipo_pregunta: r.tabla_multifinalitaria_tipo_pregunta || r.tipo_pregunta,
                    opciones: r.tabla_multifinalitaria_opciones || r.opciones,
                    requerido: r.tabla_multifinalitaria_requerido || r.requerido,
                }));
                renderCamposDinamicosCaptura(campos, data.respuestas_multifinalitaria || []);
            } else if (campaniaId) {
                promises.push(
                    $.get("{{ url('ajax/campos-dinamicos') }}", { campania_id: campaniaId, tabla_relacionada: 'captura' }, function (campos) {
                        renderCamposDinamicosCaptura(campos || []);
                    })
                );
            }

            Promise.all(promises)
                .then(() => {
                    changeArtePesca($('#tipo-arte-id').val(), !!data.id);
                })
                .finally(() => {
                    $('.spinner-overlay').addClass('d-none');
                });

            $('#captura-modal').modal('show');
        }

        function abrirObservadorModal(data = {}) {
            $('#observador-id').val(data.id || '');
            cargarTiposObservador(data.tipo_observador_id || '');
            const personaSelect = $('#persona_idpersona');
            if (data.persona_idpersona) {
                const opt = new Option(data.persona_nombres || '', data.persona_idpersona, true, true);
                personaSelect.append(opt).trigger('change');
            } else {
                personaSelect.val(null).trigger('change');
            }
            $('#observador-modal').modal('show');
        }

        function abrirTripulanteModal(data = {}) {
            $('#tripulante-id').val(data.id || '');
            cargarTiposTripulante(data.tipo_tripulante_id || '');
            const personaSelect = $('#persona_tripulante_idpersona');
            if (data.persona_idpersona) {
                const opt = new Option(data.tripulante_nombres || '', data.persona_idpersona, true, true);
                personaSelect.append(opt).trigger('change');
            } else {
                personaSelect.val(null).trigger('change');
            }
            $('#tripulante-modal').modal('show');
        }

        function editarCaptura(id) {
            $('.spinner-overlay').removeClass('d-none');
            $.ajax({
                url: `${ajaxBase}/capturas/${id}`,
                success: data => abrirModal(data),
                complete: () => $('.spinner-overlay').addClass('d-none')
            });
        }

        function editarObservador(id) {
            $.ajax({
                url: `${ajaxBase}/observadores-viaje/${id}`,
                success: data => abrirObservadorModal(data)
            });
        }

        function editarTripulante(id) {
            $.ajax({
                url: `${ajaxBase}/tripulantes-viaje/${id}`,
                success: data => abrirTripulanteModal(data)
            });
        }

        function eliminarCaptura(id) {
            if (!confirm('¿Eliminar captura?')) return;
            $.ajax({
                url: `${ajaxBase}/capturas/${id}`,
                method: 'DELETE',
                success: cargarCapturas
            });
        }

        function eliminarObservador(id) {
            if (!confirm('¿Eliminar observador?')) return;
            $.ajax({
                url: `${ajaxBase}/observadores-viaje/${id}`,
                method: 'DELETE',
                success: cargarObservadores
            });
        }

        function eliminarTripulante(id) {
            if (!confirm('¿Eliminar tripulante?')) return;
            $.ajax({
                url: `${ajaxBase}/tripulantes-viaje/${id}`,
                method: 'DELETE',
                success: cargarTripulantes
            });
        }

        $('#captura-form').on('submit', async function (e) {
            mostrarTodasLasCards();
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('was-validated');
                this.reportValidity();
                return;
            }
            e.preventDefault();
            const id = $('#captura-id').val();
            const payload = {
                nombre_comun: $('#nombre_comun').val(),
                numero_individuos: $('#numero_individuos').val(),
                peso_estimado: $('#peso_estimado').val(),
                peso_contado: $('#peso_contado').val(),
                especie_id: $('#especie_id').val(),
                viaje_id: viajeId,
                es_incidental: $('#es_incidental').val() === '1',
                es_descartada: $('#es_descartada').val() === '1',
                tipo_numero_individuos: $('#tipo_numero_individuos').val(),
                tipo_peso: $('#tipo_peso').val(),
                estado_producto: $('#estado_producto').val()
            };
            const respuestas = [];
            $('#campos-dinamicos-captura')
                .find('input[name*="[tabla_multifinalitaria_id]"]')
                .each(function () {
                    const wrap = $(this).closest('.col-md-4');
                    respuestas.push({
                        tabla_multifinalitaria_id: parseInt($(this).val()),
                        respuesta: wrap.find('[name$="[respuesta]"]').val(),
                        id: wrap.find('[name$="[id]"]').val() || 0,

                        campania_id: parseInt(wrap.find('[name$="[campania_id]"]').val()),
                        tabla_relacionada: wrap.find('[name$="[tabla_relacionada]"]').val(),
                        nombre_pregunta: wrap.find('[name$="[nombre_pregunta]"]').val(),
                        tipo_pregunta: wrap.find('[name$="[tipo_pregunta]"]').val(),
                    });
                });
            payload.respuestas_multifinalitaria = respuestas;
            console.log('Payload a enviar:', payload);

            const sitioRegistroId = $('#sitio-pesca-id').val();
            const sitioId = $('#sitio-id').val();
            const sitioProf = $('#sitio-profundidad').val();
            const sitioUnidad = $('#sitio-unidad-profundidad').val();

            if (!sitioId || !sitioProf || !sitioUnidad) {
                mostrarErrorCaptura('Complete los datos del sitio de pesca');
                return;
            }

            const url = id ? `${ajaxBase}/capturas/${id}` : `${ajaxBase}/capturas`;
            const method = id ? 'PUT' : 'POST';

            $('.spinner-overlay').removeClass('d-none');
            try {
                const capturaResp = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                });

                if (!capturaResp.ok) {
                    if (capturaResp.status === 422) {
                        const data = await capturaResp.json();
                        const messages = [];
                        Object.entries(data.errors || {}).forEach(([field, arr]) => {
                            arr.forEach(msg => messages.push(`${field}: ${msg}`));
                        });
                        mostrarErrorCaptura(messages.join('\n'));
                    } else {
                        mostrarErrorCaptura('Error al guardar la captura');
                    }
                    return;
                }

                const capturaData = await capturaResp.json();
                const capturaId = capturaData.id || capturaData.data?.id || id;

                const sitioPayload = {
                    captura_id: capturaId,
                    sitio_id: parseInt(sitioId),
                    nombre: $('#sitio-nombre').val(),
                    latitud: $('#sitio-latitud').val(),
                    longitud: $('#sitio-longitud').val(),
                    profundidad: parseFloat(sitioProf),
                    unidad_profundidad_id: parseInt(sitioUnidad)
                };
                const sitioUrl = sitioRegistroId ? `${ajaxBase}/sitios-pesca/${sitioRegistroId}` : `${ajaxBase}/sitios-pesca`;
                const sitioMethod = sitioRegistroId ? 'PUT' : 'POST';

                const sitioResp = await fetch(sitioUrl, {
                    method: sitioMethod,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(sitioPayload)
                });

                if (!sitioResp.ok) {
                    console.log(sitioResp)
                    if (sitioResp.status === 422) {
                        const data = await sitioResp.json();
                        const messages = [];
                        Object.entries(data.errors || {}).forEach(([field, arr]) => {
                            arr.forEach(msg => messages.push(`${field}: ${msg}`));
                        });
                        mostrarErrorCaptura(messages.join('\n'));
                    } else {
                        const data = await sitioResp.json().catch(() => ({}));
                        const msg = data.message || 'Error al guardar el sitio de pesca';
                        mostrarErrorCaptura(msg);
                    }
                    return;
                }
                const arteId = $('#arte-pesca-id').val();
                const artePayload = {
                    captura_id: capturaId,
                    tipo_arte_id: $('#tipo-arte-id').val(),
                    anzuelos: $('#anzuelos').val() || null,
                    tamanio_anzuelo_pulg: $('#tamanio-anzuelo-pulg').val() || null,
                    tipo_anzuelo_id: $('#tipo-anzuelo-id').val() || null,
                    largo_red_m: $('#largo-red-m').val() || null,
                    alto_red_m: $('#alto-red-m').val() || null,
                    material_malla_id: $('#material-malla-id').val() || null,
                    ojo_malla_cm: $('#ojo-malla-cm').val() || null,
                    diametro: $('#diametro').val() || null,
                    carnadaviva: $('#carnadaviva').val() === '' ? null : $('#carnadaviva').val() === '1',
                    especiecarnada: $('#especie-carnada').val() || null,
                };
                if (!$('.arte-linea-madre').hasClass('d-none')) {
                    artePayload.lineas_madre = $('#lineas-madre').val() || null;
                }
                const urlArte = arteId ? `${ajaxBase}/artes-pesca/${arteId}` : `${ajaxBase}/artes-pesca`;
                const methodArte = arteId ? 'PUT' : 'POST';
                const arteResp = await fetch(urlArte, {
                    method: methodArte,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(artePayload)
                });

                if (!arteResp.ok) {
                    console.log(arteResp)
                    if (arteResp.status === 422) {
                        const data = await arteResp.json();
                        const messages = [];
                        Object.entries(data.errors || {}).forEach(([field, arr]) => {
                            arr.forEach(msg => messages.push(`${field}: ${msg}`));
                        });
                        mostrarErrorCaptura(messages.join('\n'));
                    } else {
                        const data = await arteResp.json().catch(() => ({}));
                        const msg = data.message || 'Error al guardar el arte de pesca';
                        mostrarErrorCaptura(msg);
                    }
                    return;
                }
                const economiaId = $('#economia-venta-id').val();
                const payloadEconomia = {
                    vendido_a: $('#vendido-a').val(),
                    destino: $('#destino').val(),
                    precio: $('#precio').val(),
                    unidad_venta_id: $('#unidad-venta-id').val(),
                    captura_id: capturaId
                };
                const urlEconomia = economiaId ? `${ajaxBase}/economia-ventas/${economiaId}` : `${ajaxBase}/economia-ventas`;
                const methodEconomia = economiaId ? 'PUT' : 'POST';
                const economiaResp = await fetch(urlEconomia, {
                    method: methodEconomia,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payloadEconomia)
                });

                if (!economiaResp.ok) {
                    if (economiaResp.status === 422) {
                        const data = await economiaResp.json();
                        const messages = [];
                        Object.entries(data.errors || {}).forEach(([field, arr]) => {
                            arr.forEach(msg => messages.push(`${field}: ${msg}`));
                        });
                        mostrarErrorCaptura(messages.join('\n'));
                    } else {
                        const data = await economiaResp.json().catch(() => ({}));
                        const msg = data.message || 'Error al guardar el dato económico';
                        mostrarErrorCaptura(msg);
                    }
                    return;
                }

                const pendientes = $('#datos-biologicos-table tbody tr[data-pending="1"]').toArray();
                for (const tr of pendientes) {
                    const item = $(tr).data('item');
                    item.captura_id = capturaId;
                    const respBio = await fetch(`${ajaxBase}/datos-biologicos`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(item)
                    });
                    if (respBio.ok) {
                        const dataBio = await respBio.json();
                        $(tr).attr('data-id', dataBio.id || dataBio.data?.id).removeAttr('data-pending').removeData('item');
                    }
                }
                const pendientesArch = $('#archivos-captura-table tbody tr[data-pending="1"]').toArray();
                for (const tr of pendientesArch) {
                    const file = $(tr).data('file');
                    const fd = new FormData();
                    fd.append('archivos[]', file);
                    const respArch = await fetch(`/ajax/capturas/${capturaId}/archivos`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: fd,
                        credentials: 'same-origin'
                    }).catch(err => mostrarErrorCaptura('Error de red al subir archivo'));
                    if (!respArch?.ok) {
                        mostrarErrorCaptura('Error al subir el archivo');
                        return;
                    }
                }
                cargarDatosBiologicos(capturaId);
                cargarArchivos(capturaId);

                $('#captura-modal').modal('hide');
                cargarCapturas();
            } catch (err) {
                console.error(err);
                mostrarErrorCaptura('Error al guardar la captura');
            } finally {
                $('.spinner-overlay').addClass('d-none');
            }
        });

        $('#observador-form').on('submit', function (e) {
            e.preventDefault();
            const id = $('#observador-id').val();
            const payload = {
                viaje_id: viajeId,
                tipo_observador_id: $('#tipo_observador_id').val(),
                persona_idpersona: $('#persona_idpersona').val()
            };
            const url = id ? `${ajaxBase}/observadores-viaje/${id}` : `${ajaxBase}/observadores-viaje`;
            const method = id ? 'PUT' : 'POST';
            $.ajax({
                url,
                method,
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: () => {
                    $('#observador-modal').modal('hide');
                    cargarObservadores();
                }
            });
        });

        $('#tripulante-form').on('submit', function (e) {
            e.preventDefault();
            const id = $('#tripulante-id').val();
            const payload = {
                viaje_id: viajeId,
                tipo_tripulante_id: $('#tipo_tripulante_id').val(),
                persona_idpersona: $('#persona_tripulante_idpersona').val()
            };
            const url = id ? `${ajaxBase}/tripulantes-viaje/${id}` : `${ajaxBase}/tripulantes-viaje`;
            const method = id ? 'PUT' : 'POST';
            $.ajax({
                url,
                method,
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: () => {
                    $('#tripulante-modal').modal('hide');
                    cargarTripulantes();
                }
            });
        });

        $('#parametro-form').on('submit', function (e) {
            e.preventDefault();
            const id = $('#parametro-id').val();
            const payload = {
                viaje_id: viajeId,
                hora: $('#hora').val(),
                sondeo_ppt: $('#sondeo_ppt').val(),
                tsmp: $('#tsmp').val(),
                estado_marea_id: $('#estado_marea_id').val(),
                condicion_mar_id: $('#condicion_mar_id').val(),
                oxigeno_mg_l: $('#oxigeno_mg_l').val()
            };
            const url = id ? `${ajaxBase}/parametros-ambientales/${id}` : `${ajaxBase}/parametros-ambientales`;
            const method = id ? 'PUT' : 'POST';
            $.ajax({
                url,
                method,
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: () => {
                    $('#parametro-modal').modal('hide');
                    cargarParametrosAmbientales();
                }
            });
        });

        const ARTE_RULES = {
            default: {
                show: ['#tipo-arte-id'],
                hide: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                reset: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro']
            },
            'LÍNEA MANO, PALANGRE': {
                show: ['#tipo-arte-id', '#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada'],
                hide: ['#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                reset: ['#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro']
            },
            'ENMALLE/TRASMALLO': {
                show: ['#tipo-arte-id', '#material-malla-id', '#largo-red-m', '#alto-red-m', '#ojo-malla-cm', '#diametro'],
                hide: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada'],
                reset: ['#anzuelos', '#tamanio-anzuelo-pulg', '#tipo-anzuelo-id', '#carnadaviva', '#especie-carnada']
            }
        };

        function setFieldVisibility(selector, show, preserve = false) {
            const $fg = $(selector).closest('.form-group');
            if (show) {
                $fg.removeClass('d-none');
                $(selector).prop('required', true);
            } else {
                $fg.addClass('d-none');
                $(selector).prop('required', false);
                if (!preserve) $(selector).val('');
            }
        }

        function changeArtePesca(id, preserve = false) {
            const opt = $('#tipo-arte-id option').filter(function () { return String(this.value) === String(id); }).first();
            const tipo = String(opt.data('tipo') || '').toUpperCase(); // esperado: PALANGRE o ENMALLE

            const rules = ARTE_RULES[tipo] || ARTE_RULES.default;

            // Ocultar y resetear todos los campos
            ARTE_RULES.default.hide.forEach(s => setFieldVisibility(s, false, preserve));

            // Aplicar regla de reseteo
            if (!preserve) {
                (rules.reset || []).forEach(s => $(s).val(''));
            }

            // Mostrar/Ocultar según la regla seleccionada
            (rules.hide || []).forEach(s => setFieldVisibility(s, false, preserve));
            rules.show.forEach(s => setFieldVisibility(s, true));
        }

        $('#tipo-arte-id').on('change', e => changeArtePesca(e.target.value)).trigger('change');

        $('#btn-geolocalizar').on('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    $('#sitio-latitud').val(position.coords.latitude.toFixed(6));
                    $('#sitio-longitud').val(position.coords.longitude.toFixed(6));
                }, function () {
                    alert('No se pudo obtener la ubicación');
                });
            } else {
                alert('Geolocalización no soportada');
            }
        });

        $('#btn-mapa').on('click', function () {
            $('#mapa-modal').modal('show');
        });

        $('#mapa-modal').on('shown.bs.modal', function () {
            let lat = parseFloat($('#sitio-latitud').val());
            let lng = parseFloat($('#sitio-longitud').val());
            if (isNaN(lat) || isNaN(lng)) {
                lat = -12.046374;
                lng = -77.042793;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        lat = pos.coords.latitude;
                        lng = pos.coords.longitude;
                        mapa.setCenter({ lat, lng });
                        marcador.setPosition({ lat, lng });
                    });
                }
            }
            if (!mapa) {
                initMap(lat, lng);
            } else {
                mapa.setCenter({ lat, lng });
                marcador.setPosition({ lat, lng });
            }
        });

        $('#guardar-mapa').on('click', function () {
            const pos = marcador.getPosition();
            $('#sitio-latitud').val(pos.lat().toFixed(6));
            $('#sitio-longitud').val(pos.lng().toFixed(6));
            $('#mapa-modal').modal('hide');
        });

        if (viajeId && "{{ request()->boolean('por_finalizar') ? 'true' : 'false' }}" === 'true') {
            cargarCapturas();
            cargarObservadores();
            cargarTripulantes();
            cargarParametrosAmbientales();
            cargarEconomiaInsumo();
            $('#agregar-captura').on('click', () => abrirModal());
            $('#capturas-table').on('click', '.editar-captura', function () { editarCaptura($(this).data('id')); });
            $('#capturas-table').on('click', '.eliminar-captura', function () { eliminarCaptura($(this).data('id')); });
            $('#agregar-observador').on('click', () => abrirObservadorModal());
            $('#observadores-table').on('click', '.editar-observador', function () { editarObservador($(this).data('id')); });
            $('#observadores-table').on('click', '.eliminar-observador', function () { eliminarObservador($(this).data('id')); });
            $('#agregar-tripulante').on('click', () => abrirTripulanteModal());
            $('#tripulantes-table').on('click', '.editar-tripulante', function () { editarTripulante($(this).data('id')); });
            $('#tripulantes-table').on('click', '.eliminar-tripulante', function () { eliminarTripulante($(this).data('id')); });
            $('#agregar-parametro').on('click', () => abrirParametroModal());
            $('#parametros-ambientales-table').on('click', '.editar-parametro', function () { editarParametro($(this).data('id')); });
            $('#parametros-ambientales-table').on('click', '.eliminar-parametro', function () { eliminarParametro($(this).data('id')); });
            $('#agregar-economia-insumo').on('click', () => abrirEconomiaInsumoModal());
            $('#economia-insumo-table').on('click', '.editar-economia-insumo', function () { editarEconomiaInsumo($(this).data('id')); });
            $('#economia-insumo-table').on('click', '.eliminar-economia-insumo', function () { eliminarEconomiaInsumo($(this).data('id')); });
            $('#agregar-dato-biologico').on('click', () => abrirDatoBiologicoModal());
            $('#datos-biologicos-table').on('click', '.editar-dato-biologico', function () { editarDatoBiologico($(this).data('id')); });
            $('#datos-biologicos-table').on('click', '.eliminar-dato-biologico', function () { eliminarDatoBiologico($(this).data('id')); });
            $('#agregar-archivo-captura').on('click', () => abrirArchivoCapturaModal());
            $('#archivos-captura-table').on('click', '.eliminar-archivo-captura', function () { eliminarArchivoCaptura($(this).data('id')); });
        }
    });
</script>
@parent
@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Éxito', text: @json(session('success')) });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Error', text: @json(session('error')) });
</script>
@elseif($errors->any())
<script>
    Swal.fire({ icon: 'error', title: 'Error', html: `<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>` });
</script>
@endif
@endsection