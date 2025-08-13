@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Estructura de tallas</h3></div>
  <div class="card-body">
    
<canvas id="box"></canvas>
@push('scripts')
<script>
const tallas = {!! json_encode($rows->pluck('talla')) !!}.map(parseFloat).filter(v=>!isNaN(v));
function boxData(arr){
  arr.sort((a,b)=>a-b);
  const q = p=>arr[Math.floor((arr.length-1)*p)];
  return {min:arr[0], q1:q(0.25), med:q(0.5), q3:q(0.75), max:arr[arr.length-1]};
}
const B = boxData(tallas);
new Chart(document.getElementById('box'), { type: 'bar', data: { labels:['Min','Q1','Mediana','Q3','Max'], datasets:[{ data:[B.min,B.q1,B.med,B.q3,B.max] }] } });
</script>
@endpush

  </div>
</div>
@endsection
