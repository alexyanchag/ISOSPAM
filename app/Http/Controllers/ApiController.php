<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller {
  public function esfuerzo(Request $req) {
    // Devuelve puntos de esfuerzo por viaje/sitio para heatmap
    $desde = $req->get('desde');
    $hasta = $req->get('hasta');
    $arte = $req->get('arte');
    $especie = $req->get('especie');

    $q = DB::table('public.sitio_pesca as sp')
      ->selectRaw('sp.latitud::float as lat, sp.longitud::float as lon, count(*) as w')
      ->join('public.viaje as v', 'sp.viaje_id', '=', 'v.id')
      ->leftJoin('public.arte_pesca as ap', 'ap.viaje_id', '=', 'v.id')
      ->leftJoin('public.tipo_arte as ta', 'ta.id', '=', 'ap.tipo_arte_id')
      ->leftJoin('public.captura as c', function($j){ $j->on('c.viaje_id','=','v.id'); })
      ->leftJoin('public.especie as e', 'e.id', '=', 'c.especie_id')
      ->when($desde, fn($qq)=>$qq->whereDate('v.fecha_zarpe','>=',$desde))
      ->when($hasta, fn($qq)=>$qq->whereDate('v.fecha_arribo','<=',$hasta))
      ->when($arte, fn($qq)=>$qq->whereRaw('lower(ta.nombre)=lower(?)',[$arte]))
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->whereNull('sp.fechaborrado')
      ->groupBy('sp.latitud','sp.longitud')
      ->limit(10000);

    return response()->json($q->get());
  }

  public function sitios(Request $req) {
    $desde = $req->get('desde');
    $hasta = $req->get('hasta');
    $especie = $req->get('especie');

    $q = DB::table('public.sitio_pesca as sp')
      ->selectRaw('sp.nombre, sp.latitud::float as lat, sp.longitud::float as lon, count(distinct v.id) as viajes, sum(EXTRACT(EPOCH FROM (v.hora_arribo - v.hora_zarpe))/3600.0) as horas')
      ->join('public.viaje as v','v.id','=','sp.viaje_id')
      ->leftJoin('public.captura as c','c.viaje_id','=','v.id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($desde, fn($qq)=>$qq->whereDate('v.fecha_zarpe','>=',$desde))
      ->when($hasta, fn($qq)=>$qq->whereDate('v.fecha_arribo','<=',$hasta))
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->whereNull('sp.fechaborrado')
      ->groupBy('sp.nombre','sp.latitud','sp.longitud')
      ->orderByDesc('viajes')
      ->limit(200);

    return response()->json($q->get());
  }

  public function serie(Request $req) {
    // Serie mensual genérica por total capturas (kg)
    $puerto = $req->get('puerto');
    $arte = $req->get('arte');

    $q = DB::table('public.captura as c')
      ->selectRaw("to_char(v.fecha_arribo, 'YYYY-MM') as periodo, sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0)) as kg")
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.arte_pesca as ap','ap.viaje_id','=','v.id')
      ->leftJoin('public.tipo_arte as ta','ta.id','=','ap.tipo_arte_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->when($puerto, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$puerto]))
      ->when($arte, fn($qq)=>$qq->whereRaw('lower(ta.nombre)=lower(?)',[$arte]))
      ->groupBy('periodo')
      ->orderBy('periodo');

    return response()->json($q->get());
  }
}