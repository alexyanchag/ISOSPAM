@extends('layouts.dashboard')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Viajes por periodo</h3></div>
  <div class="card-body">
    
@if($data)
<div class="row">
  <div class="col-md-3"><div class="info-box"><span class="info-box-icon bg-primary"><i class="fas fa-ship"></i></span><div class="info-box-content"><span class="info-box-text"># Viajes</span><span class="info-box-number">{{ $data->viajes ?? 0 }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box"><span class="info-box-icon bg-info"><i class="fas fa-clock"></i></span><div class="info-box-content"><span class="info-box-text">Horas en mar</span><span class="info-box-number">{{ round($data->horas_mar ?? 0,1) }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box"><span class="info-box-icon bg-warning"><i class="fas fa-calendar-day"></i></span><div class="info-box-content"><span class="info-box-text">Días de faena</span><span class="info-box-number">{{ $data->dias_faena ?? 0 }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box"><span class="info-box-icon bg-success"><i class="fas fa-sticky-note"></i></span><div class="info-box-content"><span class="info-box-text">Obs.</span><span class="info-box-number text-truncate" style="max-width:150px;">{{ $data->observaciones }}</span></div></div></div>
</div>
@else
<p>Sin datos para los filtros.</p>
@endif

  </div>
</div>
@endsection
