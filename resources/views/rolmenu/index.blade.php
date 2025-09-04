@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Menús por Rol</h3>
        <div class="card-tools">
            <a href="{{ route('rolmenu.create') }}" class="btn btn-primary">Nuevo</a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="idrol" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los roles</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol['id'] }}" @selected($selectedRole == $rol['id'])>{{ $rol['nombrerol'] ?? $rol['id'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <table class="table table-dark table-striped table-compact">
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
                        <a href="{{ route('rolmenu.edit', ['idrol' => $item['idrol'], 'idmenu' => $item['idmenu']]) }}" class="btn btn-xs btn-secondary">Editar</a>
                        <form action="{{ route('rolmenu.destroy', ['idrol' => $item['idrol'], 'idmenu' => $item['idmenu']]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
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
