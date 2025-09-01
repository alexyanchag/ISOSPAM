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

<h4 id="form-title">Nuevo Campo</h4>
<form method="POST" id="campo-form" action="{{ route('campanias.tabla-multifinalitaria.store', $campaniaId) }}">
    @csrf
    <div id="method-field"></div>
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
    <button type="submit" class="btn btn-primary">Guardar</button>
    <button type="button" class="btn btn-secondary" id="cancel-edit" style="display:none">Cancelar</button>
    <a href="{{ route('campanias.index') }}" class="btn btn-secondary">Volver</a>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('campo-form');
    const methodField = document.getElementById('method-field');
    const tipo = document.getElementById('tipo_pregunta');
    const opcionesSection = document.getElementById('opciones-section');
    const addBtn = document.getElementById('add-opcion');
    const container = document.getElementById('opciones-container');
    const opcionesInput = document.getElementById('opciones-input');
    const cancelBtn = document.getElementById('cancel-edit');
    const formTitle = document.getElementById('form-title');
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
    });

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const data = this.dataset;
            form.action = `${baseUpdateUrl}/${data.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('tabla_relacionada').value = data.tabla;
            document.getElementById('nombre_pregunta').value = data.nombre_pregunta;
            document.getElementById('tipo_pregunta').value = data.tipo;
            const opciones = JSON.parse(data.opciones || '[]');
            container.innerHTML = '';
            if (data.tipo === 'COMBO') {
                opcionesSection.classList.remove('d-none');
                opciones.forEach(o => {
                    const val = o.value ?? o.key ?? '';
                    const div = document.createElement('div');
                    div.classList.add('input-group','mb-2');
                    div.innerHTML = `<input type="text" class="form-control opcion" value="${val}"><div class="input-group-append"><button class="btn btn-danger remove-opcion" type="button"><i class="fas fa-times"></i></button></div>`;
                    container.appendChild(div);
                });
            } else {
                opcionesSection.classList.add('d-none');
            }
            opcionesInput.value = JSON.stringify(opciones.map(o => o.value ?? o.key ?? ''));
            cancelBtn.style.display = 'inline-block';
            formTitle.textContent = 'Editar Campo';
        });
    });

    cancelBtn.addEventListener('click', function () {
        form.action = "{{ route('campanias.tabla-multifinalitaria.store', $campaniaId) }}";
        methodField.innerHTML = '';
        form.reset();
        container.innerHTML = '';
        opcionesSection.classList.add('d-none');
        opcionesInput.value = '';
        cancelBtn.style.display = 'none';
        formTitle.textContent = 'Nuevo Campo';
    });
});
</script>
@endsection
