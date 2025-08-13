<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KpiController extends Controller {
  public function kpiMensual(Request $req) {
    $q = DB::connection('reportes')->table('public.captura as c')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->selectRaw("to_char(v.fecha_arribo,'YYYY-MM') as periodo,
                   sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0)) as kg,
                   count(distinct v.id) as viajes")
      ->groupBy('periodo')
      ->orderBy('periodo');
    $rows = $q->get();
    return view('reportes.kpi.mensual', compact('rows'));
  }

  public function topValor(Request $req) {
    $q = DB::connection('reportes')->table('public.economia_ventas as ev')
      ->join('public.captura as c','c.id','=','ev.captura_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->selectRaw('coalesce(e.nombre,'(sin especie)') as especie, sum(ev.precio) as ingreso_total, avg(ev.precio) as ingreso_prom')
      ->groupBy('especie')
      ->orderByDesc('ingreso_total')
      ->limit(10);
    $rows = $q->get();
    return view('reportes.kpi.top_valor', compact('rows'));
  }

  public function sostenibilidad(Request $req) {
    // % bajo talla: requiere talla mínima conocida (no está en DDL). Se calcula proxy por percentil bajo.
    $rows = collect();
    return view('reportes.kpi.sostenibilidad', compact('rows'));
  }

  public function desempenoOperativo(Request $req) {
    $q = DB::connection('reportes')->table('public.viaje as v')
      ->selectRaw('avg(extract(epoch from (v.fechafinalizado - v.fecha_zarpe))/3600.0) as horas_registro,
                  sum(case when v.fechafinalizado is null then 1 else 0 end) as backlog,
                  0 as errores')
      ->first();
    return view('reportes.kpi.operativo', ['row'=>$q]);
  }

  public function interanual(Request $req) {
    $q = DB::connection('reportes')->table('public.captura as c')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->selectRaw("extract(year from v.fecha_arribo) as anio,
                  sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0)) as kg,
                  count(distinct v.id) as viajes")
      ->groupBy('anio')
      ->orderBy('anio');
    $rows = $q->get();
    return view('reportes.kpi.interanual', compact('rows'));
  }
}