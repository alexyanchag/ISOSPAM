@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Alertas</h3></div>
  <div class="card-body">
    
<p>Defina umbrales: % bajo talla, caídas CPUE, precios fuera de rango, sitios nuevos con esfuerzo alto.</p>
<ul>
  <li>% bajo talla &gt; <code>umbral</code></li>
  <li>CPUE mensual ↓ más de <code>X%</code> vs promedio</li>
  <li>Precios fuera de ±<code>k</code> desviaciones estándar</li>
  <li>Sitios nuevos con calor &gt; <code>N</code></li>
</ul>

  </div>
</div>
@endsection
