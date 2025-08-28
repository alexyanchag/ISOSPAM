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
