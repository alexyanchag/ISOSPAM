@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Familias</h3>
    <a href="{{ route('familias.create') }}" class="btn btn-primary">Nueva</a>
</div>


<table class="table table-dark table-striped table-compact">
    <thead>
        <tr>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($familias as $familia)
        <tr>
            <td>{{ $familia['nombre'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('familias.edit', $familia['id']) }}" class="btn btn-xs btn-secondary">Editar</a>
                <a href="{{ route('especies.index', ['familia_id' => $familia['id']]) }}" class="btn btn-xs btn-info">Especies</a>
                <form action="{{ route('familias.destroy', $familia['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
