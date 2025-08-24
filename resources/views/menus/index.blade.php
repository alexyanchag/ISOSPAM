@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Menús</h3>
    <a href="{{ route('menus.create') }}" class="btn btn-primary">Nuevo</a>
</div>


<table class="table table-dark table-striped table-compact">
    <thead>
        <tr>
            <th>Opción</th>
            <th>Nivel</th>
            <th>Padre</th>
            <th>Activo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($menus as $menu)
        <tr>
            <td>{{ $menu['opcion'] ?? '' }}</td>
            <td>{{ $menu['nivel'] ?? '' }}</td>
            <td>{{ $menu['idmenupadre'] ?? '' }}</td>
            <td>{{ isset($menu['activo']) && $menu['activo'] ? 'Sí' : 'No' }}</td>
            <td class="text-right">
                <a href="{{ route('menus.edit', $menu['id']) }}" class="btn btn-xs btn-secondary">Editar</a>
                <form action="{{ route('menus.destroy', $menu['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
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
