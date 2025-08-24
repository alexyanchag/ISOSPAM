@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection


@section('content')
<h3>{{ isset($captura) ? 'Editar' : 'Nueva' }} Captura</h3>
<form id="captura-form" method="POST" action="{{ isset($captura) ? route('capturas.update', $captura['id']) : route('capturas.store') }}">
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
        <select name="especie_id" id="especie_id" class="form-control">
            <option value="">Seleccione...</option>
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

    <div id="sitio-pesca-card" class="card mb-3 d-none">
        <div class="card-header">
            <h5 class="card-title mb-0">Sitio de pesca</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" id="sitio-nombre" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Latitud</label>
                <input type="text" id="sitio-latitud" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Longitud</label>
                <input type="text" id="sitio-longitud" class="form-control">
            </div>
        </div>
    </div>

    @php
        $respuestas = collect(old('respuestas_multifinalitaria', $captura['respuestas_multifinalitaria'] ?? []))
            ->keyBy('tabla_multifinalitaria_id');
    @endphp
    @forelse($camposDinamicos ?? [] as $campo)
        @php
            $resp = $respuestas->get($campo['id'], []);
            $required = !empty($campo['requerido']) ? 'required' : '';
        @endphp
        <div class="mb-3">
            <label class="form-label">{{ $campo['nombre_pregunta'] ?? '' }} @if($required)<span class="text-danger">*</span>@endif</label>
            @switch($campo['tipo_pregunta'])
                @case('SELECT')
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
                @case('NUMBER')
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
            <input type="hidden" name="respuestas_multifinalitaria[{{ $loop->index }}][tabla_multifinalitaria_id]" value="{{ $campo['id'] ?? 0 }}">
            <input type="hidden" name="respuestas_multifinalitaria[{{ $loop->index }}][id]" value="{{ $resp['id'] ?? 0 }}">
            @error('respuestas_multifinalitaria.' . $loop->index . '.respuesta')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    @empty
    @endforelse
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('viajes.edit', ['viaje' => old('viaje_id', $viajeId ?? $captura['viaje_id'] ?? ''), 'por_finalizar' => 1]) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('especie_id');
    const selected = @json(old('especie_id', $captura['especie_id'] ?? ''));

    fetch('{{ route('api.especies') }}')
        .then(response => response.json())
        .then(data => {
            data.forEach(e => {
                const opt = document.createElement('option');
                opt.value = e.id;
                opt.textContent = e.nombre;
                if (String(e.id) === String(selected)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        })
        .catch(err => console.error('Error al cargar especies:', err));

    const capturaId = @json($captura['id'] ?? null);
    if (capturaId) {
        const card = document.getElementById('sitio-pesca-card');
        const nombre = document.getElementById('sitio-nombre');
        const lat = document.getElementById('sitio-latitud');
        const lon = document.getElementById('sitio-longitud');
        let sitioId = null;

        fetch(`/isospam/sitios-pesca?captura_id=${capturaId}`)
            .then(r => r.ok ? r.json() : [])
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    const d = data[0];
                    sitioId = d.id;
                    nombre.value = d.nombre ?? '';
                    lat.value = d.latitud ?? '';
                    lon.value = d.longitud ?? '';
                }
                card.classList.remove('d-none');
            })
            .catch(() => card.classList.remove('d-none'));

        const form = document.getElementById('captura-form');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const payload = {
                captura_id: capturaId,
                nombre: nombre.value || null,
                latitud: lat.value || null,
                longitud: lon.value || null,
            };
            const url = sitioId ? `/isospam/sitios-pesca/${sitioId}` : '/isospam/sitios-pesca';
            const method = sitioId ? 'PUT' : 'POST';
            try {
                await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(payload),
                });
            } catch (err) {
                console.error('Error al guardar sitio de pesca:', err);
            }
            form.submit();
        });
    }
});
</script>
@endsection
