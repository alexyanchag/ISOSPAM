@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Top-N Capturas por especie</h3></div>
  <div class="card-body">
    
<canvas id="chartTop"></canvas>
<table class="table table-sm mt-3">
  <thead><tr><th>Especie</th><th>Kg</th><th>%</th></tr></thead>
  <tbody>
  @foreach($rows as $r)
    <tr><td>{{ $r->especie }}</td><td>{{ round($r->kg,1) }}</td><td>{{ $r->pct }}%</td></tr>
  @endforeach
  </tbody>
</table>
@push('scripts')
<script>
const data = {
  labels: {!! json_encode($rows->pluck('especie')) !!},
  datasets: [{ label: 'Kg', data: {!! json_encode($rows->pluck('kg')) !!} }]
};
new Chart(document.getElementById('chartTop'), { type: 'bar', data });
</script>
@endpush

  </div>
</div>
@endsection
