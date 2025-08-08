@extends('layouts.dashboard')

@section('content')
    <form id="viaje-form" method="POST" action="{{ isset($viaje) ? route('viajes.update', $viaje['id']) : route('viajes.store') }}">
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
                        <input type="date" name="fecha_zarpe" id="fecha_zarpe" class="form-control"
                            value="{{ old('fecha_zarpe', $viaje['fecha_zarpe'] ?? '') }}">
                    </div>
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Hora Zarpe</label>
                        <input type="time" name="hora_zarpe" id="hora_zarpe" class="form-control"
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
                        <input type="date" name="fecha_arribo" id="fecha_arribo" class="form-control"
                            value="{{ old('fecha_arribo', $viaje['fecha_arribo'] ?? '') }}">
                    </div>
                    <div class="col-md-3 col-lg-2 mb-3">
                        <label class="form-label">Hora Arribo</label>
                        <input type="time" name="hora_arribo" id="hora_arribo" class="form-control"
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
                <div class="card-header border-0 bg-dark">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-1"></i>
                        Observadores
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body collapse show" id="observadores-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="observadores-table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Persona</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($observadores ?? [] as $o)
                                <tr>
                                    <td>{{ $o['tipo_observador_descripcion'] ?? '' }}</td>
                                    <td>{{ $o['persona_nombres'] ?? '' }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-secondary editar-observador" data-id="{{ $o['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-observador" data-id="{{ $o['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <button id="agregar-observador" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
                </div>
            </div>

            <div class="modal fade" id="observador-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="observador-form">
                            <div class="modal-header">
                                <h5 class="modal-title">Observador</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" id="observador-id">

                                <div class="form-group">
                                    <label>Tipo de Observador</label>
                                    <select class="form-control" id="tipo_observador_id">
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Persona</label>
                                    <select class="form-control" id="persona_idpersona">
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                
                <div class="card-header border-0 bg-dark">
                    <h3 class="card-title">
                        <i class="fas fa-th mr-1"></i>
                        Capturas
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn bg-gray btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body collapse show" id="capturas-collapse">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped mb-0" id="capturas-table">
                            <thead>
                                <tr>
                                    <th>Nombre común</th>
                                    <th>Especie</th>
                                    <th>Nº Individuos</th>
                                    <th>Peso Estimado</th>
                                    <th>Peso Contado</th>
                                    <th>Incidental</th>
                                    <th>Descartada</th>
                                    <th>Tipo Nº Individuos</th>
                                    <th>Tipo Peso</th>
                                    <th>Estado Producto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($capturas ?? [] as $c)
                                <tr>
                                    <td>{{ $c['nombre_comun'] ?? '' }}</td>
                                    <td>{{ $c['especie_nombre'] ?? '' }}</td>
                                    <td>{{ $c['numero_individuos'] ?? '' }}</td>
                                    <td>{{ $c['peso_estimado'] ?? '' }}</td>
                                    <td>{{ $c['peso_contado'] ?? '' }}</td>
                                    <td>{{ ($c['es_incidental'] ?? false) ? 'Sí' : 'No' }}</td>
                                    <td>{{ ($c['es_descartada'] ?? false) ? 'Sí' : 'No' }}</td>
                                    <td>{{ $c['tipo_numero_individuos'] ?? '' }}</td>
                                    <td>{{ $c['tipo_peso'] ?? '' }}</td>
                                    <td>{{ $c['estado_producto'] ?? '' }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-secondary editar-captura" data-id="{{ $c['id'] }}">Editar</button>
                                        <button class="btn btn-sm btn-danger eliminar-captura" data-id="{{ $c['id'] }}">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                       </table>
                   </div>
                    <button id="agregar-captura" type="button" class="btn btn-primary btn-sm mt-2">Agregar</button>
                </div>
            </div>

            <div class="modal fade" id="captura-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document"> <!-- Ampliado horizontalmente -->
                    <div class="modal-content">
                        <form id="captura-form">
                            <div class="modal-header">
                                <h5 class="modal-title">Captura</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Scroll interno en el cuerpo -->
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <input type="hidden" id="captura-id">

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Nombre común</label>
                                            <input type="text" class="form-control" id="nombre_comun">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Especie</label>
                                            <select class="form-control" id="especie_id">
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Tipo Nº Individuos</label>
                                            <select class="form-control" id="tipo_numero_individuos">
                                                <option value="">Seleccione...</option>
                                                <option value="ESTIMADO">Estimado</option>
                                                <option value="MEDIDO">Medido</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Nº Individuos</label>
                                            <input type="number" min="0" step="1" class="form-control no-negative" id="numero_individuos">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Tipo Peso</label>
                                            <select class="form-control" id="tipo_peso">
                                                <option value="">Seleccione...</option>
                                                <option value="ESTIMADO">Estimado</option>
                                                <option value="MEDIDO">Medido</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Peso de captura</label>
                                            <input type="number" step="any" min="0" class="form-control no-negative" id="peso_estimado">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Estado Producto</label>
                                            <select class="form-control" id="estado_producto">
                                                <option value="">Seleccione...</option>
                                                <option value="EVISCERADO">Eviscerado</option>
                                                <option value="ENTERO">Entero</option>
                                                <option value="SIN CABEZA">Sin cabeza</option>
                                                <option value="En cola (camaron)">En cola (camaron)</option>
                                                <option value="Pulpa(concha)">Pulpa(concha)</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 d-flex align-items-center">
                                            <div class="form-check mr-3">
                                                <input type="checkbox" class="form-check-input" id="es_incidental">
                                                <label class="form-check-label" for="es_incidental">Es Incidental</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="es_descartada">
                                                <label class="form-check-label" for="es_descartada">Es Descartada</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endif
    @endisset
@endsection

@section('scripts')
    <script>
        $(function () {
            // Validación de fechas y horas de zarpe y arribo
            const fechaZarpe = document.getElementById('fecha_zarpe');
            const fechaArribo = document.getElementById('fecha_arribo');
            const horaZarpe = document.getElementById('hora_zarpe');
            const horaArribo = document.getElementById('hora_arribo');
            const form = document.getElementById('viaje-form');

            function actualizarRestricciones() {
                if (fechaArribo.value) {
                    fechaZarpe.max = fechaArribo.value;
                } else {
                    fechaZarpe.removeAttribute('max');
                }
                if (fechaZarpe.value) {
                    fechaArribo.min = fechaZarpe.value;
                } else {
                    fechaArribo.removeAttribute('min');
                }

                if (fechaZarpe.value && fechaArribo.value && fechaZarpe.value === fechaArribo.value) {
                    if (horaArribo.value) {
                        horaZarpe.max = horaArribo.value;
                    } else {
                        horaZarpe.removeAttribute('max');
                    }
                    if (horaZarpe.value) {
                        horaArribo.min = horaZarpe.value;
                    } else {
                        horaArribo.removeAttribute('min');
                    }
                } else {
                    horaZarpe.removeAttribute('max');
                    horaArribo.removeAttribute('min');
                }
            }

            fechaZarpe.addEventListener('change', actualizarRestricciones);
            fechaArribo.addEventListener('change', actualizarRestricciones);
            horaZarpe.addEventListener('change', actualizarRestricciones);
            horaArribo.addEventListener('change', actualizarRestricciones);
            form.addEventListener('submit', function (e) {
                if (fechaZarpe.value && fechaArribo.value) {
                    if (fechaZarpe.value > fechaArribo.value) {
                        e.preventDefault();
                        alert('La fecha de arribo debe ser mayor o igual a la fecha de zarpe.');
                        return;
                    }
                    if (fechaZarpe.value === fechaArribo.value && horaZarpe.value && horaArribo.value && horaZarpe.value >= horaArribo.value) {
                        e.preventDefault();
                        alert('La hora de arribo debe ser mayor que la hora de zarpe cuando las fechas son iguales.');
                    }
                }
            });

            actualizarRestricciones();

            // Evitar números negativos tanto al escribir como con las flechas
            $('.no-negative')
                .on('keydown', function (e) {
                    if (e.key === '-' || e.key === '+') {
                        e.preventDefault();
                    }
                })
                .on('input', function () {
                    this.value = this.value.replace(/-/g, '');
                });

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

            $('#persona_idpersona').select2({
                width: '100%',
                dropdownParent: $('#observador-modal'),
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
            const ajaxBase = '{{ url('ajax') }}';
            const viajeId = {{ $viaje['id'] ?? 'null' }};

            function cargarEspecies(selected = '') {
                const select = $('#especie_id');
                select.empty().append('<option value="">Seleccione...</option>');
                fetch('http://186.46.31.211:9090/isospam/especies')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(e => {
                            const opt = new Option(e.nombre, e.id, false, String(e.id) === String(selected));
                            select.append(opt);
                        });
                    })
                    .catch(err => console.error('Error al cargar especies:', err));
            }

            function cargarTiposObservador(selected = '') {
                const select = $('#tipo_observador_id');
                select.empty().append('<option value="">Seleccione...</option>');
                fetch('http://186.46.31.211:9090/isospam/tipo-observador')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(t => {
                            const opt = new Option(t.descripcion, t.id, false, String(t.id) === String(selected));
                            select.append(opt);
                        });
                    })
                    .catch(err => console.error('Error al cargar tipos de observador:', err));
            }

            function cargarCapturas() {
                $.ajax({
                    url: `${ajaxBase}/capturas-viaje`,
                    data: { viaje_id: viajeId },
                    success: data => {
                        const tbody = $('#capturas-table tbody').empty();
                        data.forEach(c => {
                            const row = `<tr>
                                <td>${c.nombre_comun ?? ''}</td>
                                <td>${c.especie_nombre ?? ''}</td>
                                <td>${c.numero_individuos ?? ''}</td>
                                <td>${c.peso_estimado ?? ''}</td>
                                <td>${c.peso_contado ?? ''}</td>
                                <td>${c.es_incidental ? 'Sí' : 'No'}</td>
                                <td>${c.es_descartada ? 'Sí' : 'No'}</td>
                                <td>${c.tipo_numero_individuos ?? ''}</td>
                                <td>${c.tipo_peso ?? ''}</td>
                                <td>${c.estado_producto ?? ''}</td>
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

            function cargarObservadores() {
                $.ajax({
                    url: `${ajaxBase}/observadores-viaje`,
                    data: { viaje_id: viajeId },
                    success: data => {
                        const tbody = $('#observadores-table tbody').empty();
                        data.forEach(o => {
                            const row = `<tr>
                                <td>${o.tipo_observador_descripcion ?? ''}</td>
                                <td>${o.persona_nombres ?? ''}</td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-secondary editar-observador" data-id="${o.id}">Editar</button>
                                    <button class="btn btn-sm btn-danger eliminar-observador" data-id="${o.id}">Eliminar</button>
                                </td>
                            </tr>`;
                            tbody.append(row);
                        });
                    }
                });
            }

            function abrirModal(data = {}) {
                $('#captura-id').val(data.id || '');
                $('#nombre_comun').val(data.nombre_comun || '');
                cargarEspecies(data.especie_id || '');
                $('#numero_individuos').val(data.numero_individuos || '');
                $('#peso_estimado').val(data.peso_estimado || '');
                $('#peso_contado').val(data.peso_contado || '');
                $('#es_incidental').prop('checked', data.es_incidental || false);
                $('#es_descartada').prop('checked', data.es_descartada || false);
                $('#tipo_numero_individuos').val(data.tipo_numero_individuos || '');
                $('#tipo_peso').val(data.tipo_peso || '');
                $('#estado_producto').val(data.estado_producto || '');
                $('#captura-modal').modal('show');
            }

            function abrirObservadorModal(data = {}) {
                $('#observador-id').val(data.id || '');
                cargarTiposObservador(data.tipo_observador_id || '');
                const personaSelect = $('#persona_idpersona');
                if (data.persona_idpersona) {
                    const opt = new Option(data.persona_nombres || '', data.persona_idpersona, true, true);
                    personaSelect.append(opt).trigger('change');
                } else {
                    personaSelect.val(null).trigger('change');
                }
                $('#observador-modal').modal('show');
            }

            function editarCaptura(id) {
                $.ajax({
                    url: `${ajaxBase}/capturas/${id}`,
                    success: data => abrirModal(data)
                });
            }

            function editarObservador(id) {
                $.ajax({
                    url: `${ajaxBase}/observadores-viaje/${id}`,
                    success: data => abrirObservadorModal(data)
                });
            }

            function eliminarCaptura(id) {
                if (!confirm('¿Eliminar captura?')) return;
                $.ajax({
                    url: `${ajaxBase}/capturas/${id}`,
                    method: 'DELETE',
                    success: cargarCapturas
                });
            }

            function eliminarObservador(id) {
                if (!confirm('¿Eliminar observador?')) return;
                $.ajax({
                    url: `${ajaxBase}/observadores-viaje/${id}`,
                    method: 'DELETE',
                    success: cargarObservadores
                });
            }

            $('#captura-form').on('submit', function (e) {
                e.preventDefault();
                const id = $('#captura-id').val();
                const payload = {
                    nombre_comun: $('#nombre_comun').val(),
                    numero_individuos: $('#numero_individuos').val(),
                    peso_estimado: $('#peso_estimado').val(),
                    peso_contado: $('#peso_contado').val(),
                    especie_id: $('#especie_id').val(),
                    viaje_id: viajeId,
                    es_incidental: $('#es_incidental').is(':checked'),
                    es_descartada: $('#es_descartada').is(':checked'),
                    tipo_numero_individuos: $('#tipo_numero_individuos').val(),
                    tipo_peso: $('#tipo_peso').val(),
                    estado_producto: $('#estado_producto').val()
                };
                console.log(payload)
                const url = id ? `${ajaxBase}/capturas/${id}` : `${ajaxBase}/capturas`;
                const method = id ? 'PUT' : 'POST';
                $.ajax({
                    url,
                    method,
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: () => {
                        $('#captura-modal').modal('hide');
                        cargarCapturas();
                    }
                });
            });

            $('#observador-form').on('submit', function (e) {
                e.preventDefault();
                const id = $('#observador-id').val();
                const payload = {
                    viaje_id: viajeId,
                    tipo_observador_id: $('#tipo_observador_id').val(),
                    persona_idpersona: $('#persona_idpersona').val()
                };
                const url = id ? `${ajaxBase}/observadores-viaje/${id}` : `${ajaxBase}/observadores-viaje`;
                const method = id ? 'PUT' : 'POST';
                $.ajax({
                    url,
                    method,
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: () => {
                        $('#observador-modal').modal('hide');
                        cargarObservadores();
                    }
                });
            });

            if (viajeId && {{ request()->boolean('por_finalizar') ? 'true' : 'false' }}) {
                cargarCapturas();
                cargarObservadores();
                $('#agregar-captura').on('click', () => abrirModal());
                $('#capturas-table').on('click', '.editar-captura', function () { editarCaptura($(this).data('id')); });
                $('#capturas-table').on('click', '.eliminar-captura', function () { eliminarCaptura($(this).data('id')); });
                $('#agregar-observador').on('click', () => abrirObservadorModal());
                $('#observadores-table').on('click', '.editar-observador', function () { editarObservador($(this).data('id')); });
                $('#observadores-table').on('click', '.eliminar-observador', function () { eliminarObservador($(this).data('id')); });
            }
        });
    </script>
@endsection
