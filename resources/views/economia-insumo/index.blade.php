@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Economía de Insumos</h3>
    @if($viajeId)
        <a href="{{ route('economia-insumo.create', ['viaje_id' => $viajeId]) }}" class="btn btn-primary">Nuevo</a>
    @endif
</div>


<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Unidad</th>
            <th>Cantidad</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($economiaInsumos as $e)
        <tr>
            <td>{{ $e['nombre_tipo'] ?? '' }}</td>
            <td>{{ $e['nombre_unidad'] ?? '' }}</td>
            <td>{{ $e['cantidad'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('economia-insumo.edit', $e['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('economia-insumo.destroy', $e['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="viaje_id" value="{{ $viajeId }}">
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
