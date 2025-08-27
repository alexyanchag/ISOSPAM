@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Costos e ingresos</h3></div>
  <div class="card-body">
    <div class="form-inline mb-3">
      <input type="date" id="fecha_inicio" class="form-control mr-2">
      <input type="date" id="fecha_fin" class="form-control mr-2">
      <button id="btn-ejecutar" class="btn btn-primary mr-2">Ejecutar</button>
      <button id="btn-pdf" class="btn btn-secondary">Descargar PDF</button>
    </div>
    <canvas id="costIncomeChart"></canvas>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfmake@0.2.7/build/pdfmake.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfmake@0.2.7/build/vfs_fonts.js"></script>
<script>
$(function(){
  let chart;
  $('#btn-ejecutar').on('click', function(){
    const fecha_inicio = $('#fecha_inicio').val();
    const fecha_fin = $('#fecha_fin').val();
    $.get('{{ route('ajax.costos_ingresos') }}', {fecha_inicio, fecha_fin}, function(resp){
      const agg = {};
      (resp || []).forEach(r => {
        const f = r.fecha;
        if(!agg[f]) agg[f] = {costos:0, ingresos:0};
        agg[f].costos += Number(r.costos || 0);
        agg[f].ingresos += Number(r.ingresos || 0);
      });
      const labels = Object.keys(agg);
      const costos = labels.map(l=>agg[l].costos);
      const ingresos = labels.map(l=>agg[l].ingresos);
      const neto = labels.map((l,i)=>ingresos[i]-costos[i]);
      const ctx = document.getElementById('costIncomeChart').getContext('2d');
      if(chart) chart.destroy();
      chart = new Chart(ctx, {
        data: {
          labels,
          datasets: [
            {type:'bar', label:'Costos', backgroundColor:'rgba(220,53,69,0.5)', data:costos},
            {type:'bar', label:'Ingresos', backgroundColor:'rgba(40,167,69,0.5)', data:ingresos},
            {type:'line', label:'Neto', borderColor:'rgba(23,162,184,1)', fill:false, data:neto}
          ]
        },
        options: {scales:{y:{beginAtZero:true}}}
      });
    });
  });

  $('#btn-pdf').on('click', function(){
    if(!chart) return;
    const img = chart.toBase64Image();
    const doc = {
      content:[
        {text:'Costos e ingresos', style:'header'},
        {image: img, width: 500}
      ],
      styles:{header:{fontSize:18,bold:true,margin:[0,0,0,10]}}
    };
    pdfMake.createPdf(doc).download('costos_ingresos.pdf');
  });
});
</script>
@endpush
