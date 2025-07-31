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
use App\Http\Controllers\UnidadLongitudController;
use App\Http\Controllers\TipoInsumoController;
use App\Http\Controllers\UnidadInsumoController;
use App\Http\Controllers\UnidadVentaController;
use App\Http\Controllers\CondicionMarController;
use App\Http\Controllers\TipoTripulanteController;
use App\Http\Controllers\TipoMotorController;
use App\Http\Controllers\TipoEmbarcacionController;
use App\Http\Controllers\TipoObservadorController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\EstadoMareaController;
use App\Http\Controllers\EstadoDesarrolloGonadalController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\EspecieController;
use App\Http\Controllers\OrganizacionPesqueraController;
use App\Http\Controllers\AsignacionResponsableController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\RolMenuController;
use App\Http\Controllers\RolPersonaController;
use App\Http\Controllers\ViajeController;

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
    Route::resource('unidadlongitud', UnidadLongitudController::class)->except(['show']);
    Route::resource('tipotripulantes', TipoTripulanteController::class)->except(['show']);
    Route::resource('tipomotores', TipoMotorController::class)->except(['show']);
    Route::resource('tipoembarcaciones', TipoEmbarcacionController::class)->except(['show']);
    Route::resource('tipoobservador', TipoObservadorController::class)->except(['show']);
    Route::resource('unidadesinsumo', UnidadInsumoController::class)->except(['show']);
    Route::resource('unidadventa', UnidadVentaController::class)->except(['show']);
    Route::resource('condicionesmar', CondicionMarController::class)->except(['show']);
    Route::resource('estadosmarea', EstadoMareaController::class)->except(['show']);
    Route::resource('estadodesarrollogonadal', EstadoDesarrolloGonadalController::class)->except(['show']);
    Route::resource('personas', PersonaController::class)->except(['show']);
    Route::get('ajax/personas', [PersonaController::class, 'buscarPorRol'])->name('ajax.personas');
    Route::resource('familias', FamiliaController::class)->except(['show']);
    Route::resource('especies', EspecieController::class)->except(['show']);
    Route::resource('organizacionpesquera', OrganizacionPesqueraController::class)->except(['show']);
    Route::resource('asignacionresponsable', AsignacionResponsableController::class)->except(['show']);
    Route::get('mis-viajes-por-finalizar', [ViajeController::class, 'misPorFinalizar'])->name('viajes.mis-por-finalizar');
    Route::put('viajes/{viaje}/por-finalizar', [ViajeController::class, 'updatePorFinalizar'])->name('viajes.por-finalizar.update');
    Route::get('viajes/pendientes', [ViajeController::class, 'pendientes'])->name('viajes.pendientes');
    Route::get('viajes/{viaje}/mostrar', [ViajeController::class, 'mostrar'])->name('viajes.mostrar');
    Route::post('viajes/{viaje}/seleccionar', [ViajeController::class, 'seleccionar'])->name('viajes.seleccionar');
    Route::resource('viajes', ViajeController::class)->except(['show']);

    Route::resource('menus', MenuController::class)->except(['show']);
    Route::resource('roles', RolController::class)->except(['show']);
    Route::get('rolmenu/{idrol}/{idmenu}/edit', [RolMenuController::class, 'edit'])->name('rolmenu.edit');
    Route::put('rolmenu/{idrol}/{idmenu}', [RolMenuController::class, 'update'])->name('rolmenu.update');
    Route::delete('rolmenu/{idrol}/{idmenu}', [RolMenuController::class, 'destroy'])->name('rolmenu.destroy');
    Route::resource('rolmenu', RolMenuController::class)->only(['index', 'create', 'store']);

    Route::delete('rolpersona/{idpersona}/{idrol}', [RolPersonaController::class, 'destroy'])->name('rolpersona.destroy');
    Route::resource('rolpersona', RolPersonaController::class)->only(['index', 'create', 'store']);
});
