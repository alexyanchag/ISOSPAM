@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Comparativo interanual</h3></div>
  <div class="card-body">
    
<canvas id="inter"></canvas>
@push('scripts')
<script>
const labels = {!! json_encode($rows->pluck('anio')) !!};
const viajes = {!! json_encode($rows->pluck('viajes')) !!};
const kg = {!! json_encode($rows->pluck('kg')) !!};
new Chart(document.getElementById('inter'), {
  type:'bar',
  data:{ labels, datasets:[{ label:'Viajes', data: viajes }, { label:'Kg', data: kg }] }
});
</script>
@endpush

  </div>
</div>
@endsection
