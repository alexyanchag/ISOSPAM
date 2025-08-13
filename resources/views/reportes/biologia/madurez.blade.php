@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Estado de madurez gonadal</h3></div>
  <div class="card-body">
    
<canvas id="madurez"></canvas>
@push('scripts')
<script>
const labels = {!! json_encode($rows->pluck('estadio')) !!};
const data = {!! json_encode($rows->pluck('n')) !!};
new Chart(document.getElementById('madurez'), { type: 'bar', data: { labels, datasets: [{ label:'N', data }] } });
</script>
@endpush

  </div>
</div>
@endsection
