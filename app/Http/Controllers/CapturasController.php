<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CapturasController extends Controller {
  public function topEspecies(Request $req) {
    $periodo = $req->get('periodo'); // YYYY-MM
    $puerto = $req->get('puerto');
    $arte = $req->get('arte');

    $q = DB::table('public.captura as c')
      ->leftJoin('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->leftJoin('public.arte_pesca as ap','ap.viaje_id','=','v.id')
      ->leftJoin('public.tipo_arte as ta','ta.id','=','ap.tipo_arte_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->when($puerto, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$puerto]))
      ->when($arte, fn($qq)=>$qq->whereRaw('lower(ta.nombre)=lower(?)',[$arte]))
      ->selectRaw("coalesce(e.nombre,'(sin especie)') as especie,
                   sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0)) as kg")
      ->groupBy('especie')
      ->orderByDesc('kg')
      ->limit(20);
    $rows = $q->get();

    // Para % participación
    $total = $rows->sum('kg');
    $rows = $rows->map(function($r) use($total){
      $r->pct = $total>0 ? round(100.0*$r->kg/$total,2) : 0;
      return $r;
    });
    return view('reportes.capturas.top', ['rows'=>$rows, 'total'=>$total]);
  }

  public function composicionPorViaje(Request $req) {
    $viaje_id = $req->get('viaje_id');
    $emb = $req->get('embarcacion');

    $q = DB::table('public.captura as c')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.embarcacion as em','em.id','=','v.embarcacion_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($viaje_id, fn($qq)=>$qq->where('v.id',$viaje_id))
      ->when($emb, fn($qq)=>$qq->whereRaw('lower(em.nombre)=lower(?)',[$emb]))
      ->selectRaw("coalesce(e.nombre,'(sin especie)') as especie,
                   sum(coalesce(c.peso_estimado,0)+coalesce(c.peso_contado,0)) as kg,
                   sum(coalesce(c.numero_individuos,0)) as n")
      ->groupBy('especie')
      ->orderByDesc('kg');

    $rows = $q->get();
    return view('reportes.capturas.composicion', compact('rows'));
  }

  public function capturasPorTamanio(Request $req) {
    $especie = $req->get('especie');
    $periodo = $req->get('periodo'); // YYYY-MM
    $puerto = $req->get('puerto');

    $q = DB::table('public.datos_biologicos as b')
      ->join('public.captura as c','c.id','=','b.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->when($puerto, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$puerto]))
      ->selectRaw('b.longitud as talla, b.peso as peso');

    $rows = $q->get();
    // En la vista se construye histograma/percentiles via JS
    return view('reportes.capturas.tallas', compact('rows'));
  }
}