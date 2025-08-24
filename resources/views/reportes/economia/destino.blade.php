@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Destino de la venta</h3></div>
  <div class="card-body">
    
<table class="table table-dark table-striped table-compact">
  <thead><tr><th>Destino</th><th>%</th><th>Ticket prom.</th></tr></thead>
  <tbody>
  @php $tot = max(1, $rows->sum('n')); @endphp
  @foreach($rows as $r)
    <tr><td>{{ $r->destino }}</td><td>{{ round(100*$r->n/$tot,1) }}%</td><td>${{ number_format($r->ticket_prom ?? 0,2) }}</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
