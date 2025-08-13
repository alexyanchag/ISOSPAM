@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Composición de especies por viaje</h3></div>
  <div class="card-body">
    
<canvas id="pie"></canvas>
@push('scripts')
<script>
const labels = {!! json_encode($rows->pluck('especie')) !!};
const kg = {!! json_encode($rows->pluck('kg')) !!};
new Chart(document.getElementById('pie'), { type: 'pie', data: { labels, datasets: [{ data: kg }] } });
</script>
@endpush

  </div>
</div>
@endsection
