@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Especies @if($familia) de {{ $familia['nombre'] ?? '' }} @endif</h3>
    <a href="{{ route('especies.create', $familiaId ? ['familia_id' => $familiaId] : []) }}" class="btn btn-primary">Nueva</a>
</div>


<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Familia</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($especies as $esp)
        <tr>
            <td>{{ $esp['nombre'] ?? '' }}</td>
            <td>{{ $esp['familia_nombre'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('especies.edit', $esp['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('especies.destroy', $esp['id']) }}{{ $familiaId ? '?familia_id='.$familiaId : '' }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($familiaId)
    <a href="{{ route('familias.index') }}" class="btn btn-secondary mt-2">Volver a Familias</a>
@endif
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
