@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    @if(session('user'))
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-3">Usuario</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1 font-weight-bold">{{ session('user.nombres') }} {{ session('user.apellidos') }}</p>
                        <p class="mb-0 text-muted">{{ session('user.email') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-3">Roles</h5>
                    </div>
                    <div class="card-body">
                        @if(session('roles'))
                            @foreach(session('roles') as $rol)
                                <div class="mb-3">
                                    <strong>{{ $rol['nombrerol'] ?? '' }}</strong>
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
