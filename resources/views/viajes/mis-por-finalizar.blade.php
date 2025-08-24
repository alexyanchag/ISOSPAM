@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Mis viajes por finalizar</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('viajes.mis-por-finalizar') }}" class="mb-3">
            <div class="form-row">
                <div class="col">
                    <select name="digitador_id" id="digitador-select" class="form-control select2">
                        <option value="">Seleccione digitador...</option>
                        @foreach($digitadores as $d)
                            <option value="{{ $d['idpersona'] }}" @selected($digitadorId == $d['idpersona'])>{{ $d['nombres'] ?? '' }} {{ $d['apellidos'] ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-secondary">Filtrar</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-dark table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Zarpe</th>
                        <th>Hora Zarpe</th>
                        <th>Fecha Arribo</th>
                        <th>Hora Arribo</th>
                        <th>Embarcación</th>
                        <th>Campaña</th>
                        <th>Responsable</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($viajes as $v)
                    <tr>
                        <td>{{ $v['id'] ?? '' }}</td>
                        <td>{{ $v['fecha_zarpe'] ?? '' }}</td>
                        <td>{{ $v['hora_zarpe'] ?? '' }}</td>
                        <td>{{ $v['fecha_arribo'] ?? '' }}</td>
                        <td>{{ $v['hora_arribo'] ?? '' }}</td>
                        <td>{{ $v['embarcacion_nombre'] ?? '' }}</td>
                        <td>{{ $v['campania_descripcion'] ?? '' }}</td>
                        <td>{{ ($v['pescador_nombres'] ?? '') . ' ' . ($v['pescador_apellidos'] ?? '') }}</td>
                        <td class="text-right">
                            <a href="{{ route('viajes.edit', ['viaje' => $v['id'], 'por_finalizar' => 1]) }}" class="btn btn-sm btn-secondary">Editar</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @if(session('success'))
        <script>
            Swal.fire({icon: 'success', title: 'Éxito', text: @json(session('success'))});
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({icon: 'error', title: 'Error', text: @json(session('error'))});
        </script>
    @elseif($errors->any())
        <script>
            Swal.fire({icon: 'error', title: 'Error', html: `<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`});
        </script>
    @endif
    <script>
        $(function () {
            $('#digitador-select').select2({
                width: '100%',
                placeholder: 'Seleccione digitador...',
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
        });
    </script>
@endsection
