@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Condiciones del Mar</h3>
    <a href="{{ route('condicionesmar.create') }}" class="btn btn-primary">Nueva</a>
</div>


<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Descripción</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($condiciones as $condicion)
        <tr>
            <td>{{ $condicion['descripcion'] ?? '' }}</td>
            <td class="text-right">
                <a href="{{ route('condicionesmar.edit', $condicion['id']) }}" class="btn btn-sm btn-secondary">Editar</a>
                <form action="{{ route('condicionesmar.destroy', $condicion['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
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
