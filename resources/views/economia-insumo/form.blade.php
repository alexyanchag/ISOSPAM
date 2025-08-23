@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($economia) ? 'Editar' : 'Nuevo' }} Economía de Insumo</h3>
<form method="POST" action="{{ isset($economia) ? route('economia-insumo.update', $economia['id']) : route('economia-insumo.store') }}">
    @csrf
    @isset($economia)
        @method('PUT')
    @endisset
    <input type="hidden" name="viaje_id" value="{{ old('viaje_id', $viajeId ?? $economia['viaje_id'] ?? '') }}">
    <div class="mb-3">
        <label class="form-label">Tipo de Insumo</label>
        <select name="tipo_insumo_id" id="tipo_insumo_id" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Unidad de Insumo</label>
        <select name="unidad_insumo_id" id="unidad_insumo_id" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Cantidad</label>
        <input type="number" step="any" name="cantidad" class="form-control" value="{{ old('cantidad', $economia['cantidad'] ?? '') }}">
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('viajes.edit', ['viaje' => old('viaje_id', $viajeId ?? $economia['viaje_id'] ?? ''), 'por_finalizar' => 1]) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo_insumo_id');
    const unidadSelect = document.getElementById('unidad_insumo_id');
    const selectedTipo = @json(old('tipo_insumo_id', $economia['tipo_insumo_id'] ?? ''));
    const selectedUnidad = @json(old('unidad_insumo_id', $economia['unidad_insumo_id'] ?? ''));

    fetch('{{ route('api.tipos-insumo') }}')
        .then(r => r.json())
        .then(data => {
            data.forEach(t => {
                const opt = new Option(t.nombre, t.id, false, String(t.id) === String(selectedTipo));
                tipoSelect.appendChild(opt);
            });
        });

    fetch('{{ route('api.unidades-insumo') }}')
        .then(r => r.json())
        .then(data => {
            data.forEach(u => {
                const opt = new Option(u.nombre, u.id, false, String(u.id) === String(selectedUnidad));
                unidadSelect.appendChild(opt);
            });
        });
});
</script>
@endsection

