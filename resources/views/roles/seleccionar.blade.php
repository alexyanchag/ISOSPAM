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
                <label for="id">Rol</label>
                <select name="id" id="id" class="form-control" required>
                    @foreach(session('roles', []) as $rol)
                        <option value="{{ $rol['id'] }}" {{ session('current_role_id') == $rol['id'] ? 'selected' : '' }}>
                            {{ $rol['nombrerol'] ?? $rol['id'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Seleccionar</button>
        </form>
    </div>
</div>
@endsection
