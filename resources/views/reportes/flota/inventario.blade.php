@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Inventario de embarcaciones</h3></div>
  <div class="card-body">
    
<table class="table table-dark table-striped table-compact">
  <tr><th>Conteo</th><td>{{ $row->conteo ?? 0 }}</td></tr>
  <tr><th>Eslora prom.</th><td>{{ round($row->eslora_prom ?? 0,2) }}</td></tr>
  <tr><th>HP prom.</th><td>{{ round($row->hp_prom ?? 0,2) }}</td></tr>
  <tr><th>Eslora (min-max)</th><td>{{ round($row->eslora_min ?? 0,2) }} - {{ round($row->eslora_max ?? 0,2) }}</td></tr>
</table>

  </div>
</div>
@endsection
