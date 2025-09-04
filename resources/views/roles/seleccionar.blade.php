@extends('layouts.app')

@section('spinner')
    <x-spinner />
@endsection

@section('body-class', 'hold-transition login-page dark-mode')
@section('container-class', 'login-box')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Seleccionar rol</p>
        <form method="POST" action="{{ url('roles/seleccionar') }}">
            @csrf
            <div class="form-group">
                <label for="idrol">Rol</label>
                <select name="idrol" id="idrol" class="form-control" required>
                    @foreach(session('roles', []) as $rol)
                        <option value="{{ $rol['idrol'] }}">{{ $rol['nombrerol'] ?? $rol['idrol'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Seleccionar</button>
        </form>
    </div>
</div>
@endsection
