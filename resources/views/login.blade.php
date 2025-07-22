@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="mb-3">Login</h3>
        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</div>
@endsection
