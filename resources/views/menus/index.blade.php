@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/menus.css') }}">
<div class="d-flex justify-content-between mb-3">
    <h3>Menús</h3>
    <a href="{{ route('menus.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<ul class="menu-tree list-unstyled">
    @include('menus.tree', ['menus' => $menus])
</ul>
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
