@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($captura) ? 'Editar' : 'Nueva' }} Captura</h3>
<form method="POST" action="{{ isset($captura) ? route('capturas.update', $captura['id']) : route('capturas.store') }}">
    @csrf
    @isset($captura)
        @method('PUT')
    @endisset
    <input type="hidden" name="viaje_id" value="{{ old('viaje_id', $viajeId ?? $captura['viaje_id'] ?? '') }}">
    <div class="mb-3">
        <label class="form-label">Nombre común</label>
        <input type="text" name="nombre_comun" class="form-control" value="{{ old('nombre_comun', $captura['nombre_comun'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nº Individuos</label>
        <input type="number" name="numero_individuos" class="form-control" value="{{ old('numero_individuos', $captura['numero_individuos'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Peso Estimado</label>
        <input type="number" step="any" name="peso_estimado" class="form-control" value="{{ old('peso_estimado', $captura['peso_estimado'] ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Especie</label>
        <select name="especie_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($especies as $e)
                <option value="{{ $e['id'] }}" @selected(old('especie_id', $captura['especie_id'] ?? '') == $e['id'])>{{ $e['nombre'] ?? '' }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="es_incidental" id="es_incidental" class="form-check-input" value="1" {{ old('es_incidental', $captura['es_incidental'] ?? false) ? 'checked' : '' }}>
        <label for="es_incidental" class="form-check-label">Es Incidental</label>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="es_descartada" id="es_descartada" class="form-check-input" value="1" {{ old('es_descartada', $captura['es_descartada'] ?? false) ? 'checked' : '' }}>
        <label for="es_descartada" class="form-check-label">Es Descartada</label>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('viajes.edit', ['viaje' => old('viaje_id', $viajeId ?? $captura['viaje_id'] ?? ''), 'por_finalizar' => 1]) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
