@extends('layouts.app')

@section('body-class', 'hold-transition login-page dark-mode')
@section('container-class', 'login-box')

@section('content')
<div class="login-logo mb-2">
    <a href="/">
        <img src="{{ asset('images/Isospam-Logotipo_Blanco_Celeste.png') }}" alt="{{ config('app.name') }}" class="img-fluid" style="max-height: 100px;">
    </a>
</div>
<div class="card card-outline card-primary">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Login</p>
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </form>
        </div>
    </div>
@endsection
