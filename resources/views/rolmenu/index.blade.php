@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Menús por Rol</h3>
    <a href="{{ route('rolmenu.create') }}" class="btn btn-primary">Nuevo</a>
</div>


<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Rol</th>
            <th>Menú</th>
            <th>Acceso</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item['nombre_rol'] ?? $item['idrol'] }}</td>
            <td>{{ $item['opcion_menu'] ?? $item['idmenu'] }}</td>
            <td>{{ $item['acceso'] }}</td>
            <td class="text-right">
                <a href="{{ route('rolmenu.edit', ['idrol' => $item['idrol'], 'idmenu' => $item['idmenu']]) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('rolmenu.destroy', ['idrol' => $item['idrol'], 'idmenu' => $item['idmenu']]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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

@section('scripts')
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
@endsection
