<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class CostosIngresosController extends Controller {
  public function index() {
    return view('reportes.economia.costos_ingresos');
  }

  public function data(Request $r, ApiService $api) {
    $res = $api->get('reporte-viajes', [
      'fecha_inicio' => $r->fecha_inicio,
      'fecha_fin' => $r->fecha_fin,
    ]);
    return response()->json($res->json());
  }
}
