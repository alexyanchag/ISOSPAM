<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EconomiaController extends Controller {
  public function resumenPorViaje(Request $req) {
    $viaje_id = $req->get('viaje_id');

    $ingresos = DB::table('public.economia_ventas as ev')
      ->join('public.captura as c','c.id','=','ev.captura_id')
      ->whereIn('c.viaje_id', function($q) use ($viaje_id){
        $q->select('id')->from('public.viaje');
        if ($viaje_id) $q->where('id',$viaje_id);
      })
      ->sum('ev.precio');

    $costos = DB::table('public.economia_insumo as ei')
      ->whereIn('ei.viaje_id', function($q) use ($viaje_id){
        $q->select('id')->from('public.viaje');
        if ($viaje_id) $q->where('id',$viaje_id);
      })
      ->selectRaw('sum(ei.cantidad) as total')->value('total');

    $utilidad = ($ingresos ?? 0) - ($costos ?? 0);
    return view('reportes.economia.viaje', compact('ingresos','costos','utilidad'));
  }

  public function precioPromedio(Request $req) {
    $especie = $req->get('especie');
    $destino = $req->get('destino');
    $periodo = $req->get('periodo');

    $q = DB::table('public.economia_ventas as ev')
      ->join('public.captura as c','c.id','=','ev.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->when($destino, fn($qq)=>$qq->whereRaw('lower(ev.destino)=lower(?)',[$destino]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->selectRaw("to_char(v.fecha_arribo,'YYYY-MM') as periodo, avg(ev.precio) as precio_medio, stddev_pop(ev.precio) as desviacion")
      ->groupBy('periodo')
      ->orderBy('periodo');
    $rows = $q->get();
    return view('reportes.economia.precios', compact('rows'));
  }

  public function margen(Request $req) {
    $arte = $req->get('arte');
    $puerto = $req->get('puerto');

    $ing = \DB::table('public.economia_ventas as ev')
      ->join('public.captura as c','c.id','=','ev.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.arte_pesca as ap','ap.viaje_id','=','v.id')
      ->leftJoin('public.tipo_arte as ta','ta.id','=','ap.tipo_arte_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->when($arte, fn($qq)=>$qq->whereRaw('lower(ta.nombre)=lower(?)',[$arte]))
      ->when($puerto, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$puerto]))
      ->selectRaw('coalesce(ta.nombre,coalesce(p.nombre,'Total')) as grupo, sum(ev.precio) as ingresos')
      ->groupBy('grupo');

    $cos = \DB::table('public.economia_insumo as ei')
      ->join('public.viaje as v','v.id','=','ei.viaje_id')
      ->leftJoin('public.arte_pesca as ap','ap.viaje_id','=','v.id')
      ->leftJoin('public.tipo_arte as ta','ta.id','=','ap.tipo_arte_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->when($arte, fn($qq)=>$qq->whereRaw('lower(ta.nombre)=lower(?)',[$arte]))
      ->when($puerto, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$puerto]))
      ->selectRaw('coalesce(ta.nombre,coalesce(p.nombre,'Total')) as grupo, sum(ei.cantidad) as costos')
      ->groupBy('grupo');

    $ing = collect($ing->get())->keyBy('grupo');
    $cos = collect($cos->get())->keyBy('grupo');

    $rows = [];
    foreach ($ing as $k=>$v){
      $ingresos = $v->ingresos ?? 0;
      $costos = $cos[$k]->costos ?? 0;
      $rows[] = (object)['grupo'=>$k,'margen'=>$ingresos - $costos];
    }
    return view('reportes.economia.margen', compact('rows'));
  }

  public function destinoVenta(Request $req) {
    $destino = $req->get('destino');
    $especie = $req->get('especie');
    $periodo = $req->get('periodo');

    $q = DB::table('public.economia_ventas as ev')
      ->join('public.captura as c','c.id','=','ev.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($destino, fn($qq)=>$qq->whereRaw('lower(ev.destino)=lower(?)',[$destino]))
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->selectRaw('ev.destino, count(*) as n, avg(ev.precio) as ticket_prom')
      ->groupBy('ev.destino')
      ->orderByDesc('n');
    $rows = $q->get();
    return view('reportes.economia.destino', compact('rows'));
  }

  public function costoInsumos(Request $req) {
    $tipo = $req->get('tipo_insumo');
    $periodo = $req->get('periodo');
    $arte = $req->get('arte');

    $q = DB::table('public.economia_insumo as ei')
      ->join('public.viaje as v','v.id','=','ei.viaje_id')
      ->leftJoin('public.arte_pesca as ap','ap.viaje_id','=','v.id')
      ->leftJoin('public.tipo_arte as ta','ta.id','=','ap.tipo_arte_id')
      ->leftJoin('public.tipo_insumo as ti','ti.id','=','ei.tipo_insumo_id')
      ->when($tipo, fn($qq)=>$qq->whereRaw('lower(ti.nombre)=lower(?)',[$tipo]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->when($arte, fn($qq)=>$qq->whereRaw('lower(ta.nombre)=lower(?)',[$arte]))
      ->selectRaw('coalesce(ti.nombre,'Total') as tipo, sum(ei.cantidad) as costo_total,
                  avg(EXTRACT(EPOCH FROM (v.hora_arribo - v.hora_zarpe))/3600.0) as horas,
                  sum(ei.cantidad)/nullif(sum(EXTRACT(EPOCH FROM (v.hora_arribo - v.hora_zarpe))/3600.0),0) as costo_por_hora')
      ->groupBy('tipo')
      ->orderByDesc('costo_total');
    $rows = $q->get();
    return view('reportes.economia.insumos', compact('rows'));
  }
}