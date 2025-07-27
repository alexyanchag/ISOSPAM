<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmbarcacionController;
use App\Http\Controllers\CampaniaController;
use App\Http\Controllers\PuertoController;
use App\Http\Controllers\MuelleController;
use App\Http\Controllers\TipoArteController;
use App\Http\Controllers\TipoAnzueloController;
use App\Http\Controllers\MaterialMallaController;
use App\Http\Controllers\SitioController;
use App\Http\Controllers\UnidadProfundidadController;
use App\Http\Controllers\TipoInsumoController;
use App\Http\Controllers\UnidadInsumoController;
use App\Http\Controllers\CondicionMarController;
use App\Http\Controllers\TipoTripulanteController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\EstadoMareaController;
use App\Http\Controllers\FamiliaController;

Route::get('/', function () {
    return view('home');
})->middleware('ensure.logged.in');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('ensure.logged.in');

Route::middleware('ensure.logged.in')->group(function () {
    Route::resource('embarcaciones', EmbarcacionController::class)->except(['show']);
    Route::resource('campanias', CampaniaController::class)->except(['show']);
    Route::resource('puertos', PuertoController::class)->except(['show']);
    Route::resource('muelles', MuelleController::class)->except(['show']);
    Route::resource('tipoartes', TipoArteController::class)->except(['show']);
    Route::resource('tipoanzuelos', TipoAnzueloController::class)->except(['show']);
    Route::resource('tiposinsumo', TipoInsumoController::class)->except(['show']);
    Route::resource('materialesmalla', MaterialMallaController::class)->except(['show']);
    Route::resource('sitios', SitioController::class)->except(['show']);
    Route::resource('unidadprofundidad', UnidadProfundidadController::class)->except(['show']);
    Route::resource('tipotripulantes', TipoTripulanteController::class)->except(['show']);
    Route::resource('unidadesinsumo', UnidadInsumoController::class)->except(['show']);
    Route::resource('condicionesmar', CondicionMarController::class)->except(['show']);
    Route::resource('estadosmarea', EstadoMareaController::class)->except(['show']);
    Route::resource('personas', PersonaController::class)->except(['show']);
    Route::resource('familias', FamiliaController::class)->except(['show']);
});
