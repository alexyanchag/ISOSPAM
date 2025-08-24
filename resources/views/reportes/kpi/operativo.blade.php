@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Desempeño operativo</h3></div>
  <div class="card-body">
    
<table class="table table-dark table-striped table-compact">
  <tr><th>Tiempo medio de registro (h)</th><td>{{ round($row->horas_registro ?? 0,2) }}</td></tr>
  <tr><th>Backlog de validación</th><td>{{ $row->backlog ?? 0 }}</td></tr>
  <tr><th>Errores</th><td>{{ $row->errores ?? 0 }}</td></tr>
</table>

  </div>
</div>
@endsection
