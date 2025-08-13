@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Resumen económico por viaje</h3></div>
  <div class="card-body">
    
<div class="row text-center">
  <div class="col-md-4"><div class="info-box"><span class="info-box-icon bg-success"><i class="fas fa-arrow-up"></i></span><div class="info-box-content"><span class="info-box-text">Ingresos</span><span class="info-box-number">${{ number_format($ingresos ?? 0,2) }}</span></div></div></div>
  <div class="col-md-4"><div class="info-box"><span class="info-box-icon bg-danger"><i class="fas fa-arrow-down"></i></span><div class="info-box-content"><span class="info-box-text">Costos</span><span class="info-box-number">${{ number_format($costos ?? 0,2) }}</span></div></div></div>
  <div class="col-md-4"><div class="info-box"><span class="info-box-icon bg-info"><i class="fas fa-equals"></i></span><div class="info-box-content"><span class="info-box-text">Utilidad</span><span class="info-box-number">${{ number_format($utilidad ?? 0,2) }}</span></div></div></div>
</div>

  </div>
</div>
@endsection
