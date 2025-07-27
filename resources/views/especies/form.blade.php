@extends('layouts.dashboard')

@section('content')
<h3>{{ isset($especie) ? 'Editar' : 'Nueva' }} Especie</h3>
<form method="POST" action="{{ isset($especie) ? route('especies.update', $especie['id']) : route('especies.store') }}">
    @csrf
    @if(isset($especie))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $especie['nombre'] ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Familia</label>
        <select name="familia_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($familias as $familia)
                <option value="{{ $familia['id'] }}" @selected(old('familia_id', $familiaId ?? ($especie['familia_id'] ?? '')) == $familia['id'])>
                    {{ $familia['nombre'] ?? '' }}
                </option>
            @endforeach
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    @if($familiaId)
        <a href="{{ route('especies.index', ['familia_id' => $familiaId]) }}" class="btn btn-secondary">Cancelar</a>
    @else
        <a href="{{ route('especies.index') }}" class="btn btn-secondary">Cancelar</a>
    @endif
</form>
@endsection
