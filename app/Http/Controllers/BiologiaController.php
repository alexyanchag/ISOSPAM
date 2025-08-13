<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BiologiaController extends Controller {
  public function estructuraTallas(Request $req) {
    $especie = $req->get('especie');
    $sexo = $req->get('sexo');
    $zona = $req->get('zona'); // puerto o sitio

    $q = DB::connection('reportes')->table('public.datos_biologicos as b')
      ->join('public.captura as c','c.id','=','b.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->when($sexo, fn($qq)=>$qq->whereRaw('lower(b.sexo)=lower(?)',[$sexo]))
      ->when($zona, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$zona]))
      ->selectRaw('b.longitud as talla, b.sexo as sexo');
    $rows = $q->get();
    return view('reportes.biologia.tallas', compact('rows'));
  }

  public function madurez(Request $req) {
    $especie = $req->get('especie');
    $periodo = $req->get('periodo'); // YYYY-MM
    $zona = $req->get('zona');

    $q = DB::connection('reportes')->table('public.datos_biologicos as b')
      ->join('public.estado_desarrollo_gonadal as g','g.id','=','b.estado_desarrollo_gonadal_id')
      ->join('public.captura as c','c.id','=','b.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->leftJoin('public.puerto as p','p.id','=','v.puerto_arribo_id')
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->when($zona, fn($qq)=>$qq->whereRaw('lower(p.nombre)=lower(?)',[$zona]))
      ->selectRaw("g.nombre as estadio, count(*) as n")
      ->groupBy('g.nombre');
    $rows = $q->get();
    return view('reportes.biologia.madurez', compact('rows'));
  }

  public function relLW(Request $req) {
    $especie = $req->get('especie');
    $periodo = $req->get('periodo');

    $q = DB::connection('reportes')->table('public.datos_biologicos as b')
      ->join('public.captura as c','c.id','=','b.captura_id')
      ->join('public.viaje as v','v.id','=','c.viaje_id')
      ->leftJoin('public.especie as e','e.id','=','c.especie_id')
      ->when($especie, fn($qq)=>$qq->whereRaw('lower(e.nombre)=lower(?)',[$especie]))
      ->when($periodo, fn($qq)=>$qq->whereRaw("to_char(v.fecha_arribo,'YYYY-MM') = ?",[$periodo]))
      ->selectRaw('b.longitud as L, b.peso as W');
    $pairs = $q->get();
    // Parámetros se ajustan en la vista (mínimos cuadrados en JS simple)
    return view('reportes.biologia.rel_lw', compact('pairs'));
  }
}