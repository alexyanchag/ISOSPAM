@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Precio promedio por especie</h3></div>
  <div class="card-body">
    
<canvas id="precios"></canvas>
@push('scripts')
<script>
const labels = {!! json_encode($rows->pluck('periodo')) !!};
const media = {!! json_encode($rows->pluck('precio_medio')) !!};
const desv = {!! json_encode($rows->pluck('desviacion')) !!};
new Chart(document.getElementById('precios'), { type:'line', data:{ labels, datasets:[{ label:'Precio medio', data: media }] } });
</script>
@endpush

  </div>
</div>
@endsection
