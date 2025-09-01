@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<h3>{{ isset($usuario) ? 'Editar' : 'Nuevo' }} Usuario</h3>
<form method="POST" action="{{ isset($usuario) ? route('usuarios.update', $usuario->idpersona) : route('usuarios.store') }}">
    @csrf
    @isset($usuario)
        @method('PUT')
    @endisset
    <div class="mb-3">
        <label class="form-label">Persona</label>
        <select id="persona_id" name="idpersona" class="form-control">
            <option value="">Seleccione...</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input type="text" name="usuario" class="form-control" value="{{ old('usuario', $usuario->usuario ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Clave</label>
        <input type="password" name="clave" class="form-control" value="{{ old('clave', $usuario->clave ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Activo</label>
        <select name="activo" class="form-control">
            <option value="1" @selected(old('activo', $usuario->activo ?? 1)==1)>Sí</option>
            <option value="0" @selected(old('activo', $usuario->activo ?? 1)==0)>No</option>
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const personaSelect = $('#persona_id');
    const usuarioInput = $('input[name="usuario"]');
    personaSelect.select2({
        width: '100%',
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: "{{ route('ajax.personas.buscar') }}",
            dataType: 'json',
            delay: 250,
            data: params => ({ filtro: params.term }),
            processResults: data => ({
                results: $.map(data, p => ({
                    id: p.idpersona,
                    text: `${p.identificacion ?? ''} - ${`${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim()}`.trim(),
                    identificacion: p.identificacion
                }))
            }),
            cache: true
        }
    });
    personaSelect.on('select2:select', e => {
        usuarioInput.val(e.params.data.identificacion || '').prop('readonly', true);
    }).on('select2:clear', () => {
        usuarioInput.val('').prop('readonly', false);
    });
    const selectedPersona = @json(old('idpersona', $usuario->idpersona ?? ''));
    if (selectedPersona) {
        fetch(`{{ route('api.personas') }}/${selectedPersona}`)
            .then(r => r.json())
            .then(p => {
                const text = `${p.identificacion ?? ''} - ${`${p.nombres ?? ''} ${p.apellidos ?? ''}`.trim()}`.trim();
                const opt = new Option(text, p.idpersona, true, true);
                personaSelect.append(opt).trigger('change');
                usuarioInput.val(p.identificacion || '').prop('readonly', true);
            });
    }
});
</script>
@endsection
