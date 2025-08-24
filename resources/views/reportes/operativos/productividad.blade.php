@extends('layouts.dashboard')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Productividad por digitador/observador</h3></div>
  <div class="card-body">
    
<table class="table table-dark table-striped table-compact">
  <thead><tr><th>Usuario</th><th>Viajes</th><th>Capturas</th><th>% Completos</th></tr></thead>
  <tbody>
  @foreach($data as $r)
    <tr><td>{{ $r->usuario }}</td><td>{{ $r->viajes_reg }}</td><td>{{ $r->capturas_reg }}</td><td>{{ round($r->pct_completos,1) }}%</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
