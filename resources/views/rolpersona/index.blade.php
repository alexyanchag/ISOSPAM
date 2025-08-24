@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Roles por Persona @if($persona) de {{ $persona['nombres'] ?? '' }} {{ $persona['apellidos'] ?? '' }} @endif</h3>
    <a href="{{ route('rolpersona.create', $personaId ? ['persona_id' => $personaId] : []) }}" class="btn btn-primary">Nuevo</a>
</div>
<form method="GET" action="{{ route('rolpersona.index') }}" class="mb-3">
    <div class="input-group">
        <select name="persona_id" class="form-control">
            <option value="">Seleccione Persona...</option>
            @foreach($personas as $p)
                <option value="{{ $p['idpersona'] }}" @selected($personaId == $p['idpersona'])>{{ $p['nombres'] ?? '' }} {{ $p['apellidos'] ?? '' }}</option>
            @endforeach
        </select>
        <div class="input-group-append">
            <button class="btn btn-secondary">Ver</button>
        </div>
    </div>
</form>
@if(session('success'))
    <script>
        Swal.fire({icon: 'success', title: 'Éxito', text: @json(session('success'))});
    </script>
@endif
@if($errors->any())
    <script>
        Swal.fire({icon: 'error', title: 'Error', html: `<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`});
    </script>
@endif
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Rol</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($roles as $r)
        <tr>
            <td>{{ $r['nombre_rol'] ?? $r['idrol'] }}</td>
            <td class="text-right">
                <form action="{{ route('rolpersona.destroy', ['idpersona' => $r['idpersona'], 'idrol' => $r['idrol']]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
