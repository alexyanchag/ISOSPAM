@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/menus.css') }}">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Menús</h3>
        <div class="card-tools">
            <a href="{{ route('menus.create') }}" class="btn btn-primary">Nuevo</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <tbody class="menu-tree">
                @include('menus.tree', ['menus' => $menus, 'level' => 0])
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/menus.js') }}"></script>
@if(session('success'))
    <script>
        Swal.fire({icon: 'success', title: 'Éxito', text: @json(session('success'))});
    </script>
@endif
@if($errors->any())
    <script>
        Swal.fire({icon: 'error', title: 'Error', html: `<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`});
    </script>
@endif
@endsection
