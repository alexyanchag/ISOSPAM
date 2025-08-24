@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Margen por arte o zona</h3></div>
  <div class="card-body">
    
<table class="table table-dark table-striped table-compact">
  <thead><tr><th>Grupo</th><th>Margen</th></tr></thead>
  <tbody>
  @foreach($rows as $r)
    <tr><td>{{ $r->grupo }}</td><td>${{ number_format($r->margen ?? 0,2) }}</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
