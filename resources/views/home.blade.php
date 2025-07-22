@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Bienvenido</h3>
        @if(session('user'))
            <p>Nombre: {{ session('user.nombres') }} {{ session('user.apellidos') }}</p>
            <p>Email: {{ session('user.email') }}</p>
        @else
            <p>No has iniciado sesión.</p>
        @endif
    </div>
</div>
@endsection
