@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Capturas por tamaño</h3></div>
  <div class="card-body">
    
<canvas id="hist"></canvas>
@push('scripts')
<script>
const tallas = {!! json_encode($rows->pluck('talla')) !!}.map(parseFloat).filter(v=>!isNaN(v));
function hist(arr, bins=20){
  const min = Math.min(...arr), max = Math.max(...arr);
  const step = (max-min)/bins;
  const edges = Array.from({length: bins}, (_,i)=>min+i*step);
  const counts = new Array(bins).fill(0);
  arr.forEach(x=>{
    const i = Math.min(Math.floor((x-min)/step), bins-1); counts[i]++;
  });
  return {edges: edges.map(e=>e.toFixed(1)), counts};
}
const H = hist(tallas, 20);
new Chart(document.getElementById('hist'), { type: 'bar', data: { labels: H.edges, datasets: [{ label:'Frecuencia', data: H.counts }] } });
</script>
@endpush

  </div>
</div>
@endsection
