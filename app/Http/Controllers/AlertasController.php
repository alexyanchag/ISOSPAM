<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AlertasController extends Controller {
  public function index(Request $req) {
    // Las reglas se evalúan en front usando umbrales configurables (sincronizados del servidor si se desea).
    return view('reportes.kpi.alertas');
  }
}