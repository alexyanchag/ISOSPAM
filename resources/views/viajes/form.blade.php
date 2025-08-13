@extends('layouts.dashboard')

@section('content')
    <form id="viaje-form" method="POST" action="{{ isset($viaje) ? route('viajes.update', $viaje['id']) : route('viajes.store') }}">
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
                            <button type="submit" formaction="{{ route('viajes.por-finalizar.update', $viaje['id']) }}" class="btn btn-warning">Finalizar</button>
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
                                <option value="{{ $c['id'] }}" @selected(old('campania_id', $viaje['campania_id'] ?? '') == $c['id'])>{{ $c['descripcion'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Responsable Viaje <span class="text-danger">*</span></label>
                        <select id="responsable-select" name="persona_idpersona" class="form-control select2">
                            <option value="">Seleccione...</option>
                            @foreach($responsables as $per)
                                <option value="{{ $per['idpersona'] }}" @selected(old('persona_idpersona', $viaje['persona_idpersona'] ?? '') == $per['idpersona'])>{{ $per['nombres'] ?? '' }}
                                    {{ $per['apellidos'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Digitador <span class="text-danger">*</span></label>
                        <select id="digitador-select" name="digitador_id" class="form-control select2">
                            <option value="">Seleccione...</option>
                            @foreach($digitadores as $d)
                                <option value="{{ $d['idpersona'] }}" @selected(old('digitador_id', $viaje['digitador_id'] ?? '') == $d['idpersona'])>{{ $d['nombres'] ?? '' }} {{ $d['apellidos'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Embarcación <span class="text-danger">*</span></label>
                        <select name="embarcacion_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($embarcaciones as $e)
                                <option value="{{ $e['id'] }}" @selected(old('embarcacion_id', $viaje['embarcacion_id'] ?? '') == $e['id'])>{{ $e['nombre'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Fecha Zarpe <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_zarpe" id="fecha_zarpe" class="form-control"
                            value="{{ old('fecha_zarpe', $viaje['fecha_zarpe'] ?? '') }}">
                    </div>
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Hora Zarpe <span class="text-danger">*</span></label>
                        <input type="time" name="hora_zarpe" id="hora_zarpe" class="form-control"
                            value="{{ old('hora_zarpe', $viaje['hora_zarpe'] ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Puerto Zarpe <span class="text-danger">*</span></label>
                        <select name="puerto_zarpe_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($puertos as $p)
                                <option value="{{ $p['id'] }}" @selected(old('puerto_zarpe_id', $viaje['puerto_zarpe_id'] ?? '') == $p['id'])>{{ $p['nombre'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Fecha Arribo <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_arribo" id="fecha_arribo" class="form-control"
                            value="{{ old('fecha_arribo', $viaje['fecha_arribo'] ?? '') }}">
                    </div>
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Hora Arribo <span class="text-danger">*</span></label>
                        <input type="time" name="hora_arribo" id="hora_arribo" class="form-control"
                            value="{{ old('hora_arribo', $viaje['hora_arribo'] ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Puerto Arribo <span class="text-danger">*</span></label>
                        <select name="puerto_arribo_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($puertos as $p)
                                <option value="{{ $p['id'] }}" @selected(old('puerto_arribo_id', $viaje['puerto_arribo_id'] ?? '') == $p['id'])>{{ $p['nombre'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Muelle</label>
                        <select name="muelle_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($muelles as $m)
                                <option value="{{ $m['id'] }}" @selected(old('muelle_id', $viaje['muelle_id'] ?? '') == $m['id'])>
                                    {{ $m['nombre'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observaciones <span class="text-danger">*</span></label>
                        <textarea name="observaciones"
                            class="form-control">{{ old('observaciones', $viaje['observaciones'] ?? '') }}</textarea>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
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
                            <label class="form-label">{{ $campo['nombre_pregunta'] ?? '' }} @if($required)<span class="text-danger">*</span>@endif</label>
                            @switch($campo['tipo_pregunta'])
                                @case('COMBO')
                                    @php $opciones = json_decode($campo['opciones'] ?? '[]', true) ?: []; @endphp
                                    <select name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]" class="form-control" {{ $required }}>
                                        <option value="">Seleccione...</option>
                                        @foreach($opciones as $opt)
                                            @php
                                                $value = is_array($opt) ? ($opt['valor'] ?? '') : (string) $opt;
                                                $text = is_array($opt) ? ($opt['texto'] ?? '') : (string) $opt;
                                            @endphp
                                            <option value="{{ $value }}" @selected(($resp['respuesta'] ?? '') == $value)>{{ $text }}</option>
                                        @endforeach
                                    </select>
                                    @break
                                @case('INTEGER')
                                    <input type="number" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]" class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                                    @break
                                @case('DATE')
                                    <input type="date" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]" class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                                    @break
                                @case('TIME')
                                    <input type="time" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]" class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                                    @break
                                @case('INPUT')
                                @default
                                    <input type="text" name="respuestas_multifinalitaria[{{ $loop->index }}][respuesta]" class="form-control" value="{{ $resp['respuesta'] ?? '' }}" {{ $required }}>
                            @endswitch
                            @if(!empty($campo['id']))
                                <input type="hidden" name="respuestas_multifinalitaria[{{ $loop->index }}][tabla_multifinalitaria_id]" value="{{ $campo['id'] }}">
                            @endif
                            @if(isset($resp['id']))
                                <input type="hidden" name="respuestas_multifinalitaria[{{ $loop->index }}][id]" value="{{ $resp['id'] }}">
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
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body collapse show" id="tripulantes-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="tripulantes-table">
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
                                        <button class="btn btn-sm btn-secondary editar-tripulante" data-id="{{ $t['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-tripulante" data-id="{{ $t['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <button id="agregar-tripulante" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
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
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body collapse show" id="observadores-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="observadores-table">
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
                                        <button class="btn btn-sm btn-secondary editar-observador" data-id="{{ $o['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-observador" data-id="{{ $o['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <button id="agregar-observador" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
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
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body collapse show" id="capturas-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="capturas-table">
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
                                        <button class="btn btn-sm btn-secondary editar-captura" data-id="{{ $c['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-captura" data-id="{{ $c['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <button id="agregar-captura" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
                </div>
            </div>

            <div class="modal fade" id="captura-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document"> <!-- Ampliado horizontalmente -->
                    <div class="modal-content">
                        <form id="captura-form">
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
                                            <label>Nombre común</label>
                                            <input type="text" class="form-control" id="nombre_comun">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Especie</label>
                                            <select class="form-control" id="especie_id">
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Tipo Nº Individuos</label>
                                            <select class="form-control" id="tipo_numero_individuos">
                                                <option value="">Seleccione...</option>
                                                <option value="ESTIMADO">Estimado</option>
                                                <option value="MEDIDO">Medido</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Nº Individuos</label>
                                            <input type="number" min="0" step="1" class="form-control no-negative" id="numero_individuos">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Tipo Peso</label>
                                            <select class="form-control" id="tipo_peso">
                                                <option value="">Seleccione...</option>
                                                <option value="ESTIMADO">Estimado</option>
                                                <option value="MEDIDO">Medido</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Peso de captura</label>
                                            <input type="number" step="any" min="0" class="form-control no-negative" id="peso_estimado">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Estado Producto</label>
                                            <select class="form-control" id="estado_producto">
                                                <option value="">Seleccione...</option>
                                                <option value="EVISCERADO">Eviscerado</option>
                                                <option value="ENTERO">Entero</option>
                                                <option value="SIN CABEZA">Sin cabeza</option>
                                                <option value="En cola (camaron)">En cola (camaron)</option>
                                                <option value="Pulpa(concha)">Pulpa(concha)</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 d-flex align-items-center">
                                            <div class="form-check mr-3">
                                                <input type="checkbox" class="form-check-input" id="es_incidental">
                                                <label class="form-check-label" for="es_incidental">Es Incidental</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="es_descartada">
                                                <label class="form-check-label" for="es_descartada">Es Descartada</label>
                                            </div>
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
            <div class="card mt-3">
                <div class="card-header border-0 bg-dark">
                    <h3 class="card-title">
                        <i class="fas fa-water mr-1"></i>
                        Parámetros Ambientales
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse show" id="parametros-ambientales-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="parametros-ambientales-table">
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
                                        <button class="btn btn-sm btn-secondary editar-parametro" data-id="{{ $p['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-parametro" data-id="{{ $p['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <button id="agregar-parametro" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
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
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse show" id="economia-insumo-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="economia-insumo-table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Unidad</th>
                                    <th>Cantidad</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($economiaInsumos ?? [] as $e)
                                <tr>
                                    <td>{{ $e['nombre_tipo'] ?? '' }}</td>
                                    <td>{{ $e['nombre_unidad'] ?? '' }}</td>
                                    <td>{{ $e['cantidad'] ?? '' }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-secondary editar-economia-insumo" data-id="{{ $e['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-economia-insumo" data-id="{{ $e['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button id="agregar-economia-insumo" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
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
                                    <label>Tipo de Insumo</label>
                                    <select class="form-control" id="tipo_insumo_id">
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Unidad de Insumo</label>
                                    <select class="form-control" id="unidad_insumo_id">
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" step="any" class="form-control" id="cantidad">
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

        @endif
    @endisset
@endsection

@section('scripts')
    <script>
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
                    switch (campo.tipo_pregunta) {
                        case 'COMBO':
                            var opciones = [];
                            try { opciones = JSON.parse(campo.opciones || '[]'); } catch (e) {}
                            control = '<select class="form-control" ' + requerido + ' name="respuestas_multifinalitaria[' + index + '][respuesta]"><option value="">Seleccione...</option>';
                              opciones.forEach(function(opt){
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
                    if (campo.id != null) {
                        control += '<input type="hidden" name="respuestas_multifinalitaria[' + index + '][tabla_multifinalitaria_id]" value="' + campo.id + '">';
                    }
                    var col = $('<div class="col-md-4 mb-3"></div>');
                    col.append('<label class="form-label">' + (campo.nombre_pregunta || '') + '</label>');
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
                $.get('{{ url('ajax/campos-dinamicos') }}', { campania_id: campaniaId, tabla_relacionada: 'viaje' }, function (data) {
                    renderCamposDinamicos(data);
                });
            });

            const ajaxBase = '{{ url('ajax') }}';
            const viajeId = {{ $viaje['id'] ?? 'null' }};

            function cargarEspecies(selected = '') {
                const select = $('#especie_id');
                select.empty().append('<option value="">Seleccione...</option>');
                fetch('http://186.46.31.211:9090/isospam/especies')
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
                fetch('http://186.46.31.211:9090/isospam/tipo-observador')
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
                fetch('http://186.46.31.211:9090/isospam/tipos-tripulante')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(t => {
                            const opt = new Option(t.descripcion, t.id, false, String(t.id) === String(selected));
                            select.append(opt);
                        });
                    })
                    .catch(err => console.error('Error al cargar tipos de tripulante:', err));
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
                                    <button class=\"btn btn-sm btn-secondary editar-tripulante\" data-id=\"${t.id}\">Editar</button>
                                    <button class=\"btn btn-sm btn-danger eliminar-tripulante\" data-id=\"${t.id}\">Eliminar</button>
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
                                    <button class="btn btn-sm btn-secondary editar-captura" data-id="${c.id}">Editar</button>
                                    <button class="btn btn-sm btn-danger eliminar-captura" data-id="${c.id}">Eliminar</button>
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
                                    <button class="btn btn-sm btn-secondary editar-observador" data-id="${o.id}">Editar</button>
                                    <button class="btn btn-sm btn-danger eliminar-observador" data-id="${o.id}">Eliminar</button>
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
                fetch('http://186.46.31.211:9090/isospam/estados-marea')
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
                fetch('http://186.46.31.211:9090/isospam/condiciones-mar')
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
                                    <button class="btn btn-sm btn-secondary editar-parametro" data-id="${p.id}">Editar</button>
                                    <button class="btn btn-sm btn-danger eliminar-parametro" data-id="${p.id}">Eliminar</button>
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
                                <td class="text-right">
                                    <button class=\"btn btn-sm btn-secondary editar-economia-insumo\" data-id=\"${e.id}\">Editar</button>
                                    <button class=\"btn btn-sm btn-danger eliminar-economia-insumo\" data-id=\"${e.id}\">Eliminar</button>
                                </td>
                            </tr>`;
                            tbody.append(row);
                        });
                    }
                });
            }

            function cargarTiposInsumo(selected = '') {
                const select = $('#tipo_insumo_id').empty().append('<option value="">Seleccione...</option>');
                fetch('http://186.46.31.211:9090/isospam/tipos-insumo')
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
                fetch('http://186.46.31.211:9090/isospam/unidades-insumo')
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(u => {
                            const opt = new Option(u.nombre, u.id, false, String(u.id) === String(selected));
                            select.append(opt);
                        });
                    });
            }

            function abrirEconomiaInsumoModal(data = {}) {
                $('#economia-insumo-id').val(data.id || '');
                $('#cantidad').val(data.cantidad || '');
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
                    cantidad: $('#cantidad').val()
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

            function abrirModal(data = {}) {
                $('#captura-id').val(data.id || '');
                $('#nombre_comun').val(data.nombre_comun || '');
                cargarEspecies(data.especie_id || '');
                $('#numero_individuos').val(data.numero_individuos || '');
                $('#peso_estimado').val(data.peso_estimado || '');
                $('#peso_contado').val(data.peso_contado || '');
                $('#es_incidental').prop('checked', data.es_incidental || false);
                $('#es_descartada').prop('checked', data.es_descartada || false);
                $('#tipo_numero_individuos').val(data.tipo_numero_individuos || '');
                $('#tipo_peso').val(data.tipo_peso || '');
                $('#estado_producto').val(data.estado_producto || '');
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
                $.ajax({
                    url: `${ajaxBase}/capturas/${id}`,
                    success: data => abrirModal(data)
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

            $('#captura-form').on('submit', function (e) {
                e.preventDefault();
                const id = $('#captura-id').val();
                const payload = {
                    nombre_comun: $('#nombre_comun').val(),
                    numero_individuos: $('#numero_individuos').val(),
                    peso_estimado: $('#peso_estimado').val(),
                    peso_contado: $('#peso_contado').val(),
                    especie_id: $('#especie_id').val(),
                    viaje_id: viajeId,
                    es_incidental: $('#es_incidental').is(':checked'),
                    es_descartada: $('#es_descartada').is(':checked'),
                    tipo_numero_individuos: $('#tipo_numero_individuos').val(),
                    tipo_peso: $('#tipo_peso').val(),
                    estado_producto: $('#estado_producto').val()
                };
                console.log(payload)
                const url = id ? `${ajaxBase}/capturas/${id}` : `${ajaxBase}/capturas`;
                const method = id ? 'PUT' : 'POST';
                $.ajax({
                    url,
                    method,
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: () => {
                        $('#captura-modal').modal('hide');
                        cargarCapturas();
                    }
                });
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

            if (viajeId && {{ request()->boolean('por_finalizar') ? 'true' : 'false' }}) {
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
            }
        });
    </script>
@endsection
