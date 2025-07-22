@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    @if(session('user'))
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Usuario</h5>
                        <p class="mb-1 fw-semibold">{{ session('user.nombres') }} {{ session('user.apellidos') }}</p>
                        <p class="mb-0 text-muted">{{ session('user.email') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Roles</h5>
                        @if(session('roles'))
                            @foreach(session('roles') as $rol)
                                <div class="mb-3">
                                    <strong>{{ $rol['nombrerol'] ?? '' }}</strong>
                                    @if(!empty($rol['menu']))
                                        <ul class="ms-3 mt-1">
                                            @foreach($rol['menu'] as $menu)
                                                <li>{{ $menu['opcion'] ?? '' }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">No has iniciado sesión.</div>
    @endif
</div>
@endsection
