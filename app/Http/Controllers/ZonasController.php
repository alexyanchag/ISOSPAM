<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ZonasController extends Controller {
  public function sitiosFrecuentes(Request $req) {
    return view('reportes.zonas.sitios');
  }
}