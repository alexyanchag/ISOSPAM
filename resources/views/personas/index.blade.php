@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Personas</h3>
        <a href="{{ route('personas.create') }}" class="btn btn-primary btn-sm">Nueva</a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('personas.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="filtro" class="form-control" placeholder="Buscar" value="{{ $filtro }}">
                <div class="input-group-append">
                    <button class="btn btn-secondary">Buscar</button>
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
        <div class="table-responsive">
            <table class="table table-dark table-striped mb-0">
    <thead>
        <tr>
            <th>Identificación</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Celular</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        <tr>
            <td>{{ $persona['identificacion'] ?? '' }}</td>
            <td>{{ $persona['nombres'] ?? '' }}</td>
            <td>{{ $persona['apellidos'] ?? '' }}</td>
            <td>{{ $persona['celular'] ?? '' }}</td>
            <td>{{ $persona['email'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('personas.edit', $persona['idpersona']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('personas.destroy', $persona['idpersona']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-right">
        <small class="text-muted mb-0">Total: {{ count($personas) }}</small>
    </div>
</div>
@endsection

