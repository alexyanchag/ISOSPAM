@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Unidades de Longitud</h3>
    <a href="{{ route('unidadlongitud.create') }}" class="btn btn-primary">Nueva</a>
</div>
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
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($unidades as $unidad)
        <tr>
            <td>{{ $unidad['nombre'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('unidadlongitud.edit', $unidad['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('unidadlongitud.destroy', $unidad['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
