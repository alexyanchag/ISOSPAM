@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title mb-0">{{ isset($viaje) ? 'Editar' : 'Nuevo' }} Viaje</h3>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ isset($viaje) ? route('viajes.update', $viaje['id']) : route('viajes.store') }}">
        @csrf
        @if(isset($viaje))
            @method('PUT')
        @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Fecha Zarpe</label>
            <input type="date" name="fecha_zarpe" class="form-control" value="{{ old('fecha_zarpe', $viaje['fecha_zarpe'] ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Hora Zarpe</label>
            <input type="time" name="hora_zarpe" class="form-control" value="{{ old('hora_zarpe', $viaje['hora_zarpe'] ?? '') }}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Fecha Arribo</label>
            <input type="date" name="fecha_arribo" class="form-control" value="{{ old('fecha_arribo', $viaje['fecha_arribo'] ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Hora Arribo</label>
            <input type="time" name="hora_arribo" class="form-control" value="{{ old('hora_arribo', $viaje['hora_arribo'] ?? '') }}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control">{{ old('observaciones', $viaje['observaciones'] ?? '') }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Muelle</label>
            <select name="muelle_id" class="form-control">
                <option value="">Seleccione...</option>
                @foreach($muelles as $m)
                    <option value="{{ $m['id'] }}" @selected(old('muelle_id', $viaje['muelle_id'] ?? '') == $m['id'])>{{ $m['nombre'] ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Puerto Zarpe</label>
            <select name="puerto_zarpe_id" class="form-control">
                <option value="">Seleccione...</option>
                @foreach($puertos as $p)
                    <option value="{{ $p['id'] }}" @selected(old('puerto_zarpe_id', $viaje['puerto_zarpe_id'] ?? '') == $p['id'])>{{ $p['nombre'] ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Puerto Arribo</label>
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
            <label class="form-label">Responsable</label>
            <select id="responsable-select" name="persona_idpersona" class="form-control select2">
                <option value="">Seleccione...</option>
                @foreach($responsables as $per)
                    <option value="{{ $per['idpersona'] }}" @selected(old('persona_idpersona', $viaje['persona_idpersona'] ?? '') == $per['idpersona'])>{{ $per['nombres'] ?? '' }} {{ $per['apellidos'] ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Embarcación</label>
            <select name="embarcacion_id" class="form-control">
                <option value="">Seleccione...</option>
                @foreach($embarcaciones as $e)
                    <option value="{{ $e['id'] }}" @selected(old('embarcacion_id', $viaje['embarcacion_id'] ?? '') == $e['id'])>{{ $e['nombre'] ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Digitador</label>
            <select id="digitador-select" name="digitador_id" class="form-control select2">
                <option value="">Seleccione...</option>
                @foreach($digitadores as $d)
                    <option value="{{ $d['idpersona'] }}" @selected(old('digitador_id', $viaje['digitador_id'] ?? '') == $d['idpersona'])>{{ $d['nombres'] ?? '' }} {{ $d['apellidos'] ?? '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Campaña</label>
            <select name="campania_id" class="form-control">
                <option value="">Seleccione...</option>
                @foreach($campanias as $c)
                    <option value="{{ $c['id'] }}" @selected(old('campania_id', $viaje['campania_id'] ?? '') == $c['id'])>{{ $c['descripcion'] ?? '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('viajes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('#responsable-select').select2({
            width: '100%',
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
    });
</script>
@endsection
