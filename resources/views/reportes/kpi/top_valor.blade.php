@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Top 10 especies por valor económico</h3></div>
  <div class="card-body">
    
<table class="table table-dark table-striped table-compact">
  <thead><tr><th>Especie</th><th>Ingreso total</th><th>Ingreso promedio</th></tr></thead>
  <tbody>
  @foreach($rows as $r)
    <tr><td>{{ $r->especie }}</td><td>${{ number_format($r->ingreso_total ?? 0,2) }}</td><td>${{ number_format($r->ingreso_prom ?? 0,2) }}</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
