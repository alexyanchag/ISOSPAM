<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlotaController extends Controller {
  public function inventario(Request $req) {
    $tipo = $req->get('tipo_embarcacion');
    $motor = $req->get('motor');
    $estado = $req->get('estado'); // si existiese

    $q = DB::table('public.embarcacion as e')
      ->leftJoin('public.tipo_embarcacion as te','te.id','=','e.tipo_embarcacion_id')
      ->leftJoin('public.tipo_motor as tm','tm.id','=','e.tipo_motor_id')
      ->when($tipo, fn($qq)=>$qq->whereRaw('lower(te.nombre)=lower(?)',[$tipo]))
      ->when($motor, fn($qq)=>$qq->whereRaw('tm.motor_hp::text = ?',[$motor]))
      ->selectRaw('count(*) as conteo, avg(e.eslora) as eslora_prom, avg(tm.motor_hp) as hp_prom, min(e.eslora) as eslora_min, max(e.eslora) as eslora_max');
    $row = $q->first();
    return view('reportes.flota.inventario', compact('row'));
  }

  public function productividad(Request $req) {
    $emb = $req->get('embarcacion');
    $periodo = $req->get('periodo');

    $q = DB::table('public.viaje as v')
      ->leftJoin('public.embarcacion as e','e.id','=','v.embarcacion_id')
      ->leftJoin('public.captura as c','c.viaje_id','=','v.id')
      ->when($emb, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$emb]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->selectRaw("coalesce(e.nombre,'(sin embarcación)') as embarcacion,
                   count(distinct v.id) as viajes,
                   sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0)) as kg,
                   sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0))/nullif(count(distinct v.id),0) as cpue")
      ->groupBy('embarcacion')
      ->orderByDesc('kg');
    $rows = $q->get();
    return view('reportes.flota.productividad', compact('rows'));
  }

  public function tripulacion(Request $req) {
    $tipo = $req->get('tipo_tripulante');
    $periodo = $req->get('periodo');
    $emb = $req->get('embarcacion');

    $q = DB::table('public.tripulante_viaje as tv')
      ->join('public.viaje as v','v.id','=','tv.viaje_id')
      ->leftJoin('public.tipo_tripulante as tt','tt.id','=','tv.tipo_tripulante_id')
      ->leftJoin('public.embarcacion as e','e.id','=','v.embarcacion_id')
      ->when($tipo, fn($qq)=>$qq->whereRaw('lower(tt.descripcion)=lower(?)',[$tipo]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->when($emb, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$emb]))
      ->selectRaw("coalesce(tt.descripcion,'Total') as tipo, count(distinct tv.persona_idpersona) as n_tripulantes")
      ->groupBy('tipo')
      ->orderByDesc('n_tripulantes');
    $rows = $q->get();
    return view('reportes.flota.tripulacion', compact('rows'));
  }

  public function seguridad(Request $req) {
    // Placeholder: depende de que existan tablas de incidentes.
    $rows = collect([]);
    return view('reportes.flota.seguridad', compact('rows'));
  }
}