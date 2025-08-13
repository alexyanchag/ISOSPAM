@extends('layouts.dashboard')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Mapa de esfuerzo (Heatmap)</h3></div>
  <div class="card-body">
    
<div id="heatmap"></div>
@push('scripts')
<script>
const map = L.map('heatmap').setView([-0.7,-80.1], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18}).addTo(map);

fetch(`{{ route('api.esfuerzo') }}?desde=&hasta=`)
  .then(r=>r.json())
  .then(points=>{
    const heat = points.map(p=>[p.lat, p.lon, Math.max(1, p.w)]);
    L.heatLayer(heat, {radius: 22, blur: 15}).addTo(map);
  });
</script>
@endpush

  </div>
</div>
@endsection
