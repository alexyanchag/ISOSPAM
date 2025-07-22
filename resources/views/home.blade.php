@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Bienvenido</h3>
        @if(session('user'))
            <p>Nombre: {{ session('user.nombres') }} {{ session('user.apellidos') }}</p>
            <p>Email: {{ session('user.email') }}</p>

            @if(session('roles'))
                <h4 class="mt-4">Roles</h4>
                @foreach(session('roles') as $rol)
                    <div class="mb-3">
                        <h5>{{ $rol['nombrerol'] ?? '' }}</h5>
                        @if(!empty($rol['menu']))
                            <ul class="ms-3">
                                @foreach($rol['menu'] as $menu)
                                    <li>{{ $menu['opcion'] ?? '' }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @endif
        @else
            <p>No has iniciado sesión.</p>
        @endif
    </div>
</div>
@endsection
