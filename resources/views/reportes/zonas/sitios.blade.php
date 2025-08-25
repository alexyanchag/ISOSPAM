@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Sitios de pesca más frecuentes</h3></div>
  <div class="card-body">
    
<div id="map"></div>
<table class="table table-dark table-striped table-compact mt-3" id="tabla"></table>
@push('scripts')
<script>
const map = L.map('map').setView([-0.7,-80.1], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18}).addTo(map);

fetch(`{{ route('api.sitios.reporte') }}`)
  .then(r=>r.json())
  .then(rows=>{
    rows.forEach(r=>{
      L.marker([r.lat,r.lon]).addTo(map).bindPopup(`<b>${r.nombre||'(sin nombre)'}</b><br>Viajes: ${r.viajes}<br>Horas: ${parseFloat(r.horas||0).toFixed(1)}`);
    });
    const tbl = document.getElementById('tabla');
    tbl.innerHTML = '<thead><tr><th>Sitio</th><th>Viajes</th><th>Horas</th></tr></thead>'+
      '<tbody>'+rows.map(r=>`<tr><td>${r.nombre||'(sin nombre)'}</td><td>${r.viajes}</td><td>${(r.horas||0).toFixed(1)}</td></tr>`).join('')+'</tbody>';
  });
</script>
@endpush

  </div>
</div>
@endsection
