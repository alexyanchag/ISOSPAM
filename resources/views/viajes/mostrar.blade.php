@extends('layouts.dashboard')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Detalle del viaje</h3>
        <div class="card-tools">
            @if(!($viajeSeleccionado ?? false))
                <form method="POST" action="{{ route('viajes.seleccionar', $viaje['id']) }}" class="seleccionar-form d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Seleccionar</button>
                </form>
            @endif
            <a href="{{ route('viajes.pendientes') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Campaña</label>
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($campanias as $c)
                        <option value="{{ $c['id'] }}" @selected(($viaje['campania_id'] ?? '')==$c['id'])>{{ $c['descripcion'] ?? '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Responsable Viaje</label>
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($responsables as $per)
                        <option value="{{ $per['idpersona'] }}" @selected(($viaje['persona_idpersona'] ?? '')==$per['idpersona'])>{{ $per['nombres'] ?? '' }} {{ $per['apellidos'] ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Digitador</label>
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($digitadores as $d)
                        <option value="{{ $d['idpersona'] }}" @selected(($viaje['digitador_id'] ?? '')==$d['idpersona'])>{{ $d['nombres'] ?? '' }} {{ $d['apellidos'] ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Embarcación</label>
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($embarcaciones as $e)
                        <option value="{{ $e['id'] }}" @selected(($viaje['embarcacion_id'] ?? '')==$e['id'])>{{ $e['nombre'] ?? '' }}</option>
                    @endforeach
                </select>
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
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($puertos as $p)
                        <option value="{{ $p['id'] }}" @selected(($viaje['puerto_zarpe_id'] ?? '')==$p['id'])>{{ $p['nombre'] ?? '' }}</option>
                    @endforeach
                </select>
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
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($puertos as $p)
                        <option value="{{ $p['id'] }}" @selected(($viaje['puerto_arribo_id'] ?? '')==$p['id'])>{{ $p['nombre'] ?? '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Muelle</label>
                <select class="form-control" disabled>
                    <option value="">Seleccione...</option>
                    @foreach($muelles as $m)
                        <option value="{{ $m['id'] }}" @selected(($viaje['muelle_id'] ?? '')==$m['id'])>{{ $m['nombre'] ?? '' }}</option>
                    @endforeach
                </select>
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
    @php
        $respuestas = array_filter($viaje['respuestas_multifinalitaria'], function($r) {
            return isset($r['respuesta']) && $r['respuesta'] !== '';
        });
    @endphp
    @if(!empty($respuestas))
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Campos dinámicos</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($respuestas as $r)
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
                                    <input type="number" class="form-control" value="{{ $r['respuesta'] ?? '' }}" disabled>
                                    @break
                                @case('DATE')
                                    <input type="date" class="form-control" value="{{ $r['respuesta'] ?? '' }}" disabled>
                                    @break
                                @case('TIME')
                                    <input type="time" class="form-control" value="{{ $r['respuesta'] ?? '' }}" disabled>
                                    @break
                                @case('INPUT')
                                @default
                                    <input type="text" class="form-control" value="{{ $r['respuesta'] ?? '' }}" disabled>
                            @endswitch
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
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
                        <th>Detalles</th>
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
                            <td>
                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                    data-target="#capturaModal{{ $c['id'] ?? $loop->index }}">Ver</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No hay capturas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    </div>
</div>

@foreach($capturas ?? [] as $captura)
<div class="modal fade" id="capturaModal{{ $captura['id'] ?? $loop->index }}" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Captura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre común</label>
                            <p class="form-control-plaintext">{{ $captura['nombre_comun'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Especie</label>
                            <p class="form-control-plaintext">{{ $captura['especie_nombre'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tipo Nº Individuos</label>
                            <p class="form-control-plaintext">{{ $captura['tipo_numero_individuos'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nº Individuos</label>
                            <p class="form-control-plaintext">{{ $captura['numero_individuos'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tipo Peso</label>
                            <p class="form-control-plaintext">{{ $captura['tipo_peso'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Peso de captura</label>
                            <p class="form-control-plaintext">{{ $captura['peso_estimado'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Estado Producto</label>
                            <p class="form-control-plaintext">{{ $captura['estado_producto'] ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Es Incidental</label>
                            <p class="form-control-plaintext">{{ ($captura['es_incidental'] ?? false) ? 'Sí' : 'No' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Es Descartada</label>
                            <p class="form-control-plaintext">{{ ($captura['es_descartada'] ?? false) ? 'Sí' : 'No' }}</p>
                        </div>
                        @if(!empty($captura['respuestas_multifinalitaria']))
                            @foreach($captura['respuestas_multifinalitaria'] as $r)
                                <div class="col-md-4 mb-3">
                                    <label>{{ $r['nombre_pregunta'] ?? '' }}</label>
                                    <p class="form-control-plaintext">{{ $r['respuesta'] ?? '' }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if(!empty($captura['sitios_pesca']))
                        @php $s = $captura['sitios_pesca'][0] ?? null; @endphp
                        <div id="sitio-pesca-card" class="card mb-3">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Sitio de pesca</h5>
                            </div>
                            <div class="card-body">
                                @if($s)
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Nombre</label>
                                            <p class="form-control-plaintext">{{ $s['nombre'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Latitud</label>
                                            <p class="form-control-plaintext">{{ $s['latitud'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Longitud</label>
                                            <p class="form-control-plaintext">{{ $s['longitud'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Profundidad</label>
                                            <p class="form-control-plaintext">{{ $s['profundidad'] ?? '' }} {{ $s['unidad_profundidad_nombre'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="mb-0">No registrado.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(!empty($captura['artes_pesca']))
                        @php $a = $captura['artes_pesca'][0] ?? null; @endphp
                        <div id="arte-pesca-card" class="card mb-3">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Arte de pesca</h5>
                            </div>
                            <div class="card-body">
                                @if($a)
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Tipo de arte</label>
                                            <p class="form-control-plaintext">{{ $a['tipo_arte_nombre'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Líneas madre</label>
                                            <p class="form-control-plaintext">{{ $a['lineas_madre'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Anzuelos</label>
                                            <p class="form-control-plaintext">{{ $a['anzuelos'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Tipo anzuelo</label>
                                            <p class="form-control-plaintext">{{ $a['tipo_anzuelo_nombre'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Tamaño anzuelo (pulg)</label>
                                            <p class="form-control-plaintext">{{ $a['tamanio_anzuelo_pulg'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Largo red (m)</label>
                                            <p class="form-control-plaintext">{{ $a['largo_red_m'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Ancho red (m)</label>
                                            <p class="form-control-plaintext">{{ $a['alto_red_m'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Material malla</label>
                                            <p class="form-control-plaintext">{{ $a['material_malla_nombre'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Ojo malla (cm)</label>
                                            <p class="form-control-plaintext">{{ $a['ojo_malla_cm'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Diámetro</label>
                                            <p class="form-control-plaintext">{{ $a['diametro'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Carnada viva</label>
                                            <p class="form-control-plaintext">{{ isset($a['carnadaviva']) ? ($a['carnadaviva'] ? 'Sí' : 'No') : '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Especie carnada</label>
                                            <p class="form-control-plaintext">{{ $a['especiecarnada'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="mb-0">No registrado.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(!empty($captura['economia_ventas']))
                        @php $ev = $captura['economia_ventas'][0] ?? null; @endphp
                        <div id="economia-venta-card" class="card mb-3">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Dato económico</h5>
                            </div>
                            <div class="card-body">
                                @if($ev)
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Vendido a</label>
                                            <p class="form-control-plaintext">{{ $ev['vendido_a'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Destino</label>
                                            <p class="form-control-plaintext">{{ $ev['destino'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Precio</label>
                                            <p class="form-control-plaintext">{{ $ev['precio'] ?? '' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Unidad de venta</label>
                                            <p class="form-control-plaintext">{{ $ev['unidad_venta_nombre'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="mb-0">No registrado.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if(!empty($captura['datos_biologicos']))
                        <div id="dato-biologico-card" class="card mb-3">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Datos biológicos</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-compact mb-0">
                                        <thead>
                                            <tr>
                                                <th>Longitud</th>
                                                <th>Peso</th>
                                                <th>Sexo</th>
                                                <th>Ovada</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($captura['datos_biologicos'] as $d)
                                                <tr>
                                                    <td>{{ $d['longitud'] ?? '' }}</td>
                                                    <td>{{ $d['peso'] ?? '' }}</td>
                                                    <td>{{ $d['sexo'] ?? '' }}</td>
                                                    <td>{{ ($d['ovada'] ?? false) ? 'Sí' : 'No' }}</td>
                                                    <td>{{ $d['estado_desarrollo_gonadal_descripcion'] ?? '' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No hay datos registrados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!empty($captura['archivos']))
                        <div id="archivo-captura-card" class="card mb-3">
                            <div class="card-header border-0 bg-dark">
                                <h5 class="card-title mb-0">Archivos</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-compact mb-0">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Tamaño</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($captura['archivos'] as $a)
                                                <tr>
                                                    <td><a href="{{ $a['url'] ?? '#' }}" target="_blank">{{ $a['nombre_original'] ?? '' }}</a></td>
                                                    <td>{{ $a['tamano'] ?? '' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center">No hay archivos.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

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

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Observadores</h3>
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
                    @forelse($observadores ?? [] as $o)
                        <tr>
                            <td>{{ $o['tipo_observador_descripcion'] ?? '' }}</td>
                            <td>{{ $o['persona_nombres'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No hay observadores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Parámetros Ambientales</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
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
                    @forelse($parametrosAmbientales ?? [] as $p)
                        <tr>
                            <td>{{ $p['hora'] ?? '' }}</td>
                            <td>{{ $p['sondeo_ppt'] ?? '' }}</td>
                            <td>{{ $p['tsmp'] ?? '' }}</td>
                            <td>{{ $p['estado_marea_descripcion'] ?? '' }}</td>
                            <td>{{ $p['condicion_mar_descripcion'] ?? '' }}</td>
                            <td>{{ $p['oxigeno_mg_l'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay parámetros registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title">Economía de Insumos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($economiaInsumos ?? [] as $e)
                        <tr>
                            <td>{{ $e['nombre_tipo'] ?? '' }}</td>
                            <td>{{ $e['nombre_unidad'] ?? '' }}</td>
                            <td>{{ $e['cantidad'] ?? '' }}</td>
                            <td>{{ $e['precio'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay economía de insumos registrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.seleccionar-form').forEach(form=>{
    form.addEventListener('submit', e=>{
        e.preventDefault();
        Swal.fire({
            title:'¿Seleccionar este viaje?',
            icon:'question',
            showCancelButton:true,
            confirmButtonText:'Sí, seleccionar',
            cancelButtonText:'Cancelar'
        }).then(res=>{ if(res.isConfirmed) form.submit(); });
    });
});
</script>
@endsection
