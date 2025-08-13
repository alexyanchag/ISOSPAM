@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Costo de insumos por viaje</h3></div>
  <div class="card-body">
    
<table class="table table-sm">
  <thead><tr><th>Tipo</th><th>Costo total</th><th>Costo por hora</th></tr></thead>
  <tbody>
  @foreach($rows as $r)
    <tr><td>{{ $r->tipo }}</td><td>${{ number_format($r->costo_total ?? 0,2) }}</td><td>${{ number_format($r->costo_por_hora ?? 0,2) }}</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
