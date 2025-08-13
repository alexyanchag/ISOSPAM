@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Tripulantes por viaje/rol</h3></div>
  <div class="card-body">
    
<table class="table table-sm">
  <thead><tr><th>Rol</th><th># Tripulantes</th></tr></thead>
  <tbody>
  @foreach($rows as $r)
    <tr><td>{{ $r->tipo }}</td><td>{{ $r->n_tripulantes }}</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
