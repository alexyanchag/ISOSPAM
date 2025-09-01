@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<h3>Tabla Multifinalitaria</h3>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<button type="button" class="btn btn-success mb-3" id="btn-add">Nuevo</button>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Tabla relacionada</th>
            <th>Nombre de pregunta</th>
            <th>Tipo</th>
            <th>Opciones</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($campos as $campo)
            <tr>
                <td>{{ $campo['tabla_relacionada'] ?? '' }}</td>
                <td>{{ $campo['nombre_pregunta'] ?? '' }}</td>
                <td>{{ $campo['tipo_pregunta'] ?? '' }}</td>
                <td>
                    @if(!empty($campo['opciones']))
                        {{ implode(', ', array_map(fn($o) => $o['value'] ?? $o['key'], $campo['opciones'])) }}
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary btn-edit"
                        data-id="{{ $campo['id'] }}"
                        data-tabla="{{ $campo['tabla_relacionada'] }}"
                        data-nombre_pregunta="{{ $campo['nombre_pregunta'] }}"
                        data-tipo="{{ $campo['tipo_pregunta'] }}"
                        data-opciones='{{ json_encode($campo["opciones"] ?? []) }}'>Editar</button>
                    <form method="POST" action="{{ route('campanias.tabla-multifinalitaria.destroy', [$campaniaId, $campo['id']]) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Sin registros</td></tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('campanias.index') }}" class="btn btn-secondary">Volver</a>

<!-- Modal -->
<div class="modal fade" id="campoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="campo-form" action="{{ route('campanias.tabla-multifinalitaria.store', $campaniaId) }}">
            @csrf
            <div id="method-field"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="campoModalLabel">Nuevo Campo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="campo_id" id="campo_id">
                    <div class="mb-3">
                        <label class="form-label">Tabla Relacionada</label>
                        <select name="tabla_relacionada" class="form-control" id="tabla_relacionada">
                            <option value="">Seleccione</option>
                            <option value="captura">Captura</option>
                            <option value="viaje">Viaje</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Campo</label>
                        <input type="text" name="nombre_pregunta" class="form-control" id="nombre_pregunta">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Pregunta</label>
                        <select name="tipo_pregunta" class="form-control" id="tipo_pregunta">
                            <option value="">Seleccione</option>
                            <option value="COMBO">COMBO</option>
                            <option value="INTEGER">INTEGER</option>
                            <option value="DATE">DATE</option>
                            <option value="TIME">TIME</option>
                            <option value="INPUT">INPUT</option>
                        </select>
                    </div>
                    <div id="opciones-section" class="mb-3 d-none">
                        <label class="form-label">Opciones</label>
                        <div id="opciones-container"></div>
                        <button type="button" class="btn btn-sm btn-secondary" id="add-opcion">Agregar opción</button>
                        <input type="hidden" name="opciones" id="opciones-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const campoModalEl = document.getElementById('campoModal');
    const campoModal = new bootstrap.Modal(campoModalEl);
    const form = document.getElementById('campo-form');
    const methodField = document.getElementById('method-field');
    const tipo = document.getElementById('tipo_pregunta');
    const opcionesSection = document.getElementById('opciones-section');
    const addBtn = document.getElementById('add-opcion');
    const container = document.getElementById('opciones-container');
    const opcionesInput = document.getElementById('opciones-input');
    const formTitle = document.getElementById('campoModalLabel');
    const campoIdInput = document.getElementById('campo_id');
    const baseUpdateUrl = "{{ url('campanias/'.$campaniaId.'/tabla-multifinalitaria') }}";

    function refreshOpciones() {
        const values = Array.from(container.querySelectorAll('.opcion')).map(i => i.value).filter(v => v.trim() !== '');
        opcionesInput.value = JSON.stringify(values);
    }

    tipo.addEventListener('change', function () {
        if (this.value === 'COMBO') {
            opcionesSection.classList.remove('d-none');
        } else {
            opcionesSection.classList.add('d-none');
            container.innerHTML = '';
            opcionesInput.value = '';
        }
    });

    addBtn.addEventListener('click', function () {
        const div = document.createElement('div');
        div.classList.add('input-group','mb-2');
        div.innerHTML = '<input type="text" class="form-control opcion"><div class="input-group-append"><button class="btn btn-danger remove-opcion" type="button"><i class="fas fa-times"></i></button></div>';
        container.appendChild(div);
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.remove-opcion')) {
            e.target.closest('.input-group').remove();
            refreshOpciones();
        }
    });

    form.addEventListener('submit', function () {
        refreshOpciones();
        campoModal.hide();
    });

    function resetModal() {
        form.action = "{{ route('campanias.tabla-multifinalitaria.store', $campaniaId) }}";
        methodField.innerHTML = '';
        form.reset();
        campoIdInput.value = '';
        container.innerHTML = '';
        opcionesSection.classList.add('d-none');
        opcionesInput.value = '';
        formTitle.textContent = 'Nuevo Campo';
    }

    function openModal(isEdit = false, data = {}) {
        resetModal();
        if (isEdit) {
            form.action = `${baseUpdateUrl}/${data.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            campoIdInput.value = data.id;
            document.getElementById('tabla_relacionada').value = data.tabla;
            document.getElementById('nombre_pregunta').value = data.nombre_pregunta;
            document.getElementById('tipo_pregunta').value = data.tipo;
            const opciones = JSON.parse(data.opciones || '[]');
            if (data.tipo === 'COMBO') {
                opcionesSection.classList.remove('d-none');
                opciones.forEach(o => {
                    const val = o.value ?? o.key ?? '';
                    const div = document.createElement('div');
                    div.classList.add('input-group','mb-2');
                    div.innerHTML = `<input type=\"text\" class=\"form-control opcion\" value=\"${val}\"><div class=\"input-group-append\"><button class=\"btn btn-danger remove-opcion\" type=\"button\"><i class=\"fas fa-times\"></i></button></div>`;
                    container.appendChild(div);
                });
                opcionesInput.value = JSON.stringify(opciones.map(o => o.value ?? o.key ?? ''));
            }
            formTitle.textContent = 'Editar Campo';
        }
        campoModal.show();
    }

    document.getElementById('btn-add').addEventListener('click', () => openModal(false));

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => openModal(true, btn.dataset));
    });
});
</script>
@endsection
