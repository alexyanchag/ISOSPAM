@extends('layouts.dashboard')

@section('content')
    <form method="POST" action="{{ isset($viaje) ? route('viajes.update', $viaje['id']) : route('viajes.store') }}">
        @csrf
        @if(isset($viaje))
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ isset($viaje) ? 'Editar' : 'Nuevo' }} Viaje</h3>
                <div class="card-tools">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    @isset($viaje)
                        @if(request()->boolean('por_finalizar'))
                            <button type="submit" formaction="{{ route('viajes.por-finalizar.update', $viaje['id']) }}" class="btn btn-warning">Finalizar</button>
                        @endif
                    @endisset
                    <a href="{{ route('viajes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Campaña</label>
                        <select name="campania_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($campanias as $c)
                                <option value="{{ $c['id'] }}" @selected(old('campania_id', $viaje['campania_id'] ?? '') == $c['id'])>{{ $c['descripcion'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Responsable Viaje</label>
                        <select id="responsable-select" name="persona_idpersona" class="form-control select2">
                            <option value="">Seleccione...</option>
                            @foreach($responsables as $per)
                                <option value="{{ $per['idpersona'] }}" @selected(old('persona_idpersona', $viaje['persona_idpersona'] ?? '') == $per['idpersona'])>{{ $per['nombres'] ?? '' }}
                                    {{ $per['apellidos'] ?? '' }}</option>
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
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Embarcación</label>
                        <select name="embarcacion_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($embarcaciones as $e)
                                <option value="{{ $e['id'] }}" @selected(old('embarcacion_id', $viaje['embarcacion_id'] ?? '') == $e['id'])>{{ $e['nombre'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Fecha Zarpe</label>
                        <input type="date" name="fecha_zarpe" class="form-control"
                            value="{{ old('fecha_zarpe', $viaje['fecha_zarpe'] ?? '') }}">
                    </div>
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Hora Zarpe</label>
                        <input type="time" name="hora_zarpe" class="form-control"
                            value="{{ old('hora_zarpe', $viaje['hora_zarpe'] ?? '') }}">
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
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Fecha Arribo</label>
                        <input type="date" name="fecha_arribo" class="form-control"
                            value="{{ old('fecha_arribo', $viaje['fecha_arribo'] ?? '') }}">
                    </div>
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Hora Arribo</label>
                        <input type="time" name="hora_arribo" class="form-control"
                            value="{{ old('hora_arribo', $viaje['hora_arribo'] ?? '') }}">
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
                        <label class="form-label">Muelle</label>
                        <select name="muelle_id" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($muelles as $m)
                                <option value="{{ $m['id'] }}" @selected(old('muelle_id', $viaje['muelle_id'] ?? '') == $m['id'])>
                                    {{ $m['nombre'] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones"
                            class="form-control">{{ old('observaciones', $viaje['observaciones'] ?? '') }}</textarea>
                    </div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
            </div>
        </div>
    </form>

    @isset($viaje)
        @if(request()->boolean('por_finalizar'))
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Capturas</h3>
                    <button class="btn btn-tool" type="button" data-toggle="collapse" data-target="#capturas-collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="card-body collapse show" id="capturas-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="capturas-table">
                            <thead>
                                <tr>
                                    <th>Nombre común</th>
                                    <th>Nº Individuos</th>
                                    <th>Peso Estimado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($capturas ?? [] as $c)
                                <tr>
                                    <td>{{ $c['nombre_comun'] ?? '' }}</td>
                                    <td>{{ $c['numero_individuos'] ?? '' }}</td>
                                    <td>{{ $c['peso_estimado'] ?? '' }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('capturas.edit', $c['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                                        <form action="{{ route('capturas.destroy', $c['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="viaje_id" value="{{ $viaje['id'] }}">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <a href="{{ route('capturas.create', ['viaje_id' => $viaje['id']]) }}" class="btn btn-primary btn-sm mt-2">Agregar</a>
                </div>
            </div>
        @endif
    @endisset
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#responsable-select').select2({
                width: '100%',
            placeholder: 'Seleccione...',
            allowClear: true,
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
            placeholder: 'Seleccione...',
            allowClear: true,
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
            const apiBase = 'http://186.46.31.211:9090';
            const token = '{{ session('token') }}';
            const viajeId = {{ $viaje['id'] ?? 'null' }};

            function authHeaders() {
                return token ? { Authorization: `Bearer ${token}` } : {};
            }

            function cargarCapturas() {
                $.ajax({
                    url: `${apiBase}/isospam/capturas-viaje`,
                    data: { viaje_id: viajeId },
                    headers: authHeaders(),
                    success: data => {
                        const tbody = $('#capturas-table tbody').empty();
                        data.forEach(c => {
                            const row = `<tr>
                                <td>${c.nombre_comun ?? ''}</td>
                                <td>${c.numero_individuos ?? ''}</td>
                                <td>${c.peso_estimado ?? ''}</td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-secondary editar-captura" data-id="${c.id}">Editar</button>
                                    <button class="btn btn-sm btn-danger eliminar-captura" data-id="${c.id}">Eliminar</button>
                                </td>
                            </tr>`;
                            tbody.append(row);
                        });
                    }
                });
            }

            function crearCaptura() {
                const nombre = prompt('Nombre común');
                if (nombre === null) return;
                const num = prompt('Número de individuos');
                const peso = prompt('Peso estimado');
                $.ajax({
                    url: `${apiBase}/isospam/capturas`,
                    method: 'POST',
                    headers: Object.assign({ 'Content-Type': 'application/json' }, authHeaders()),
                    data: JSON.stringify({
                        nombre_comun: nombre,
                        numero_individuos: num,
                        peso_estimado: peso,
                        viaje_id: viajeId
                    }),
                    success: cargarCapturas
                });
            }

            function editarCaptura(id) {
                $.ajax({
                    url: `${apiBase}/isospam/capturas/${id}`,
                    headers: authHeaders(),
                    success: data => {
                        const nombre = prompt('Nombre común', data.nombre_comun);
                        if (nombre === null) return;
                        const num = prompt('Número de individuos', data.numero_individuos);
                        const peso = prompt('Peso estimado', data.peso_estimado);
                        $.ajax({
                            url: `${apiBase}/isospam/capturas/${id}`,
                            method: 'PUT',
                            headers: Object.assign({ 'Content-Type': 'application/json' }, authHeaders()),
                            data: JSON.stringify({
                                nombre_comun: nombre,
                                numero_individuos: num,
                                peso_estimado: peso,
                                peso_contado: data.peso_contado,
                                especie_id: data.especie_id,
                                viaje_id: viajeId,
                                es_incidental: data.es_incidental,
                                es_descartada: data.es_descartada,
                                tipo_numero_individuos: data.tipo_numero_individuos,
                                tipo_peso: data.tipo_peso,
                                estado_producto: data.estado_producto
                            }),
                            success: cargarCapturas
                        });
                    }
                });
            }

            function eliminarCaptura(id) {
                if (!confirm('¿Eliminar captura?')) return;
                $.ajax({
                    url: `${apiBase}/isospam/capturas/${id}`,
                    method: 'DELETE',
                    headers: authHeaders(),
                    success: cargarCapturas
                });
            }

            if (viajeId && {{ request()->boolean('por_finalizar') ? 'true' : 'false' }}) {
                cargarCapturas();
                $('#agregar-captura').on('click', crearCaptura);
                $('#capturas-table').on('click', '.editar-captura', function () { editarCaptura($(this).data('id')); });
                $('#capturas-table').on('click', '.eliminar-captura', function () { eliminarCaptura($(this).data('id')); });
            }
        });
    </script>
@endsection
