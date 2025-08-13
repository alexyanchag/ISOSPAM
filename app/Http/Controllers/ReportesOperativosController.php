<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesOperativosController extends Controller {
  public function viajesPeriodo(Request $req) {
    $fecha1 = $req->get('desde');
    $fecha2 = $req->get('hasta');
    $puerto = $req->get('puerto');
    $muelle = $req->get('muelle');
    $tipo = $req->get('tipo_monitoreo');
    $usuario = $req->get('usuario');

    $q = DB::connection('reportes')->table('public.viaje as v')
      ->leftJoin('public.puerto as pz','pz.id','=','v.puerto_zarpe_id')
      ->leftJoin('public.puerto as pa','pa.id','=','v.puerto_arribo_id')
      ->leftJoin('public.muelle as m','m.id','=','v.muelle_id')
      ->leftJoin('public.digitador as d','d.id','=','v.digitador_id')
      ->when($fecha1, fn($qq)=>$qq->whereDate('v.fecha_zarpe','>=',$fecha1))
      ->when($fecha2, fn($qq)=>$qq->whereDate('v.fecha_arribo','<=',$fecha2))
      ->when($puerto, fn($qq)=>$qq->whereRaw('lower(pa.nombre)=lower(?) or lower(pz.nombre)=lower(?)',[$puerto,$puerto]))
      ->when($muelle, fn($qq)=>$qq->whereRaw('lower(m.nombre)=lower(?)',[$muelle]))
      ->when($tipo, fn($qq)=>$qq->whereRaw('lower(v.observaciones) like ?',["%".strtolower($tipo)."%"])) // placeholder (no campo tipo_monitoreo estándar en 'viaje')
      ->when($usuario, fn($qq)=>$qq->whereRaw('lower(d.nombres)=lower(?) or lower(d.apellidos)=lower(?)',[ $usuario, $usuario ]))
      ->selectRaw("count(distinct v.id) as viajes,
          sum(EXTRACT(EPOCH FROM (v.hora_arribo - v.hora_zarpe))/3600.0) as horas_mar,
          sum((v.fecha_arribo - v.fecha_zarpe)) as dias_faena,
          string_agg(distinct coalesce(v.observaciones,''), ' | ') as observaciones");

    $data = $q->first();
    return view('reportes.operativos.viajes', compact('data'));
  }

  public function mapaEsfuerzo(Request $req) {
    return view('reportes.operativos.esfuerzo');
  }

  public function productividadUsuarios(Request $req) {
    $usuario = $req->get('usuario');
    $desde = $req->get('desde');
    $hasta = $req->get('hasta');

    $q = DB::connection('reportes')->table('public.viaje as v')
      ->leftJoin('public.digitador as d','d.id','=','v.digitador_id')
      ->leftJoin('public.captura as c','c.viaje_id','=','v.id')
      ->when($usuario, fn($qq)=>$qq->whereRaw('lower(d.nombres)=lower(?) or lower(d.apellidos)=lower(?)',[ $usuario, $usuario ]))
      ->when($desde, fn($qq)=>$qq->whereDate('v.fecha_zarpe','>=',$desde))
      ->when($hasta, fn($qq)=>$qq->whereDate('v.fecha_arribo','<=',$hasta))
      ->selectRaw("coalesce(d.nombres,'')||' '||coalesce(d.apellidos,'') as usuario,
                  count(distinct v.id) as viajes_reg,
                  count(c.id) as capturas_reg,
                  100.0 * sum(case when v.fechafinalizado is not null then 1 else 0 end)/nullif(count(distinct v.id),0) as pct_completos")
      ->groupBy('usuario');

    $data = $q->get();
    return view('reportes.operativos.productividad', compact('data'));
  }
}