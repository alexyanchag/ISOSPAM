@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Organizaciones Pesqueras</h3>
    <a href="{{ route('organizacionpesquera.create') }}" class="btn btn-primary">Nueva</a>
</div>


<table class="table table-dark table-striped table-compact">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Zona</th>
            <th>Es Red ISOSPAM</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($organizaciones as $org)
        <tr>
            <td>{{ $org['nombre'] ?? '' }}</td>
            <td>{{ $org['zona'] ?? '' }}</td>
            <td>{{ isset($org['es_red_issopam']) && $org['es_red_issopam'] ? 'Sí' : 'No' }}</td>
            <td class="text-right">
                <a href="{{ route('organizacionpesquera.edit', $org['id']) }}" class="btn btn-xs btn-secondary">Editar</a>
                <form action="{{ route('organizacionpesquera.destroy', $org['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
