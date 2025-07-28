@extends('layouts.dashboard')

@section('content')
<h3>Asignar Rol a Persona</h3>
<form method="POST" action="{{ route('rolpersona.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Persona</label>
        <select name="idpersona" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($personas as $p)
                <option value="{{ $p['idpersona'] }}" @selected(old('idpersona', $personaId ?? '') == $p['idpersona'])>{{ $p['nombres'] ?? '' }} {{ $p['apellidos'] ?? '' }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="idrol" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($roles as $r)
                <option value="{{ $r['id'] }}" @selected(old('idrol') == $r['id'])>{{ $r['nombrerol'] ?? $r['id'] }}</option>
            @endforeach
        </select>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('rolpersona.index', $personaId ? ['persona_id' => $personaId] : []) }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
