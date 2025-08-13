@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Productividad por embarcación</h3></div>
  <div class="card-body">
    
<table class="table table-sm">
  <thead><tr><th>Embarcación</th><th>Viajes</th><th>Kg</th><th>CPUE</th></tr></thead>
  <tbody>
  @foreach($rows as $r)
    <tr><td>{{ $r->embarcacion }}</td><td>{{ $r->viajes }}</td><td>{{ round($r->kg ?? 0,1) }}</td><td>{{ round($r->cpue ?? 0,1) }}</td></tr>
  @endforeach
  </tbody>
</table>

  </div>
</div>
@endsection
