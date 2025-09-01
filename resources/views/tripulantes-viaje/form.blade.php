@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($tripulante) ? 'Editar' : 'Nuevo' }} Tripulante</h3>
<form method="POST" action="{{ isset($tripulante) ? route('tripulantes-viaje.update', $tripulante['id']) : route('tripulantes-viaje.store') }}">
    @csrf
    @isset($tripulante)
        @method('PUT')
    @endisset
    <input type="hidden" name="viaje_id" value="{{ old('viaje_id', $viajeId ?? $tripulante['viaje_id'] ?? '') }}">
    <div class="mb-3">
        <label class="form-label">Tipo de Tripulante</label>
        <select name="tipo_tripulante_id" id="tipo_tripulante_id" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Persona</label>
        <select name="persona_idpersona" id="persona_idpersona" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Organización Pesquera</label>
        <select name="organizacion_pesquera_id" id="organizacion_pesquera_id" class="form-control" required>
            <option value="">Seleccione...</option>
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('viajes.edit', ['viaje' => old('viaje_id', $viajeId ?? $tripulante['viaje_id'] ?? ''), 'por_finalizar' => 1]) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo_tripulante_id');
    const personaSelect = $('#persona_idpersona');
    const orgSelect = document.getElementById('organizacion_pesquera_id');
    const selectedTipo = @json(old('tipo_tripulante_id', $tripulante['tipo_tripulante_id'] ?? ''));
    fetch('{{ route('api.tipos-tripulante') }}')
        .then(r => r.json())
        .then(data => {
            data.forEach(t => {
                const opt = new Option(t.descripcion, t.id, false, String(t.id) === String(selectedTipo));
                tipoSelect.appendChild(opt);
            });
        });
    const selectedOrg = @json(old('organizacion_pesquera_id', $tripulante['organizacion_pesquera_id'] ?? ''));
    fetch('{{ route('api.organizacion-pesquera') }}')
        .then(r => r.json())
        .then(data => {
            data.forEach(o => {
                const opt = new Option(o.nombre ?? o.id, o.id, false, String(o.id) === String(selectedOrg));
                orgSelect.appendChild(opt);
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
            data: params => ({ filtro: params.term, rol: 'TRIPVJ' }),
            processResults: data => ({
                results: $.map(data, p => ({ id: p.idpersona, text: `${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim() }))
            }),
            cache: true
        }
    });
    const selectedPersona = @json(old('persona_idpersona', $tripulante['persona_idpersona'] ?? ''));
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
