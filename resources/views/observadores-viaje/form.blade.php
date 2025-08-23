@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($observador) ? 'Editar' : 'Nuevo' }} Observador</h3>
<form method="POST" action="{{ isset($observador) ? route('observadores-viaje.update', $observador['id']) : route('observadores-viaje.store') }}">
    @csrf
    @isset($observador)
        @method('PUT')
    @endisset
    <input type="hidden" name="viaje_id" value="{{ old('viaje_id', $viajeId ?? $observador['viaje_id'] ?? '') }}">
    <div class="mb-3">
        <label class="form-label">Tipo de Observador</label>
        <select name="tipo_observador_id" id="tipo_observador_id" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Persona</label>
        <select name="persona_idpersona" id="persona_idpersona" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('viajes.edit', ['viaje' => old('viaje_id', $viajeId ?? $observador['viaje_id'] ?? ''), 'por_finalizar' => 1]) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo_observador_id');
    const personaSelect = $('#persona_idpersona');
    const selectedTipo = @json(old('tipo_observador_id', $observador['tipo_observador_id'] ?? ''));
    fetch('{{ route('api.tipo-observador') }}')
        .then(r => r.json())
        .then(data => {
            data.forEach(t => {
                const opt = new Option(t.descripcion, t.id, false, String(t.id) === String(selectedTipo));
                tipoSelect.appendChild(opt);
            });
        });
    personaSelect.select2({
        width: '100%',
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
    const selectedPersona = @json(old('persona_idpersona', $observador['persona_idpersona'] ?? ''));
    if (selectedPersona) {
        fetch(`{{ route('api.personas') }}/${selectedPersona}`)
            .then(r => r.json())
            .then(p => {
                const opt = new Option(`${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim(), p.idpersona, true, true);
                personaSelect.append(opt).trigger('change');
            });
    }
});
</script>
@endsection

