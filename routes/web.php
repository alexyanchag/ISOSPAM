<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmbarcacionController;
use App\Http\Controllers\CampaniaController;
use App\Http\Controllers\TablaMultifinalitariaController;
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
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ViajeController;
use App\Http\Controllers\CapturaController;
use App\Http\Controllers\CapturaAjaxController;
use App\Http\Controllers\ObservadorViajeController;
use App\Http\Controllers\ObservadorViajeAjaxController;
use App\Http\Controllers\TripulanteViajeController;
use App\Http\Controllers\TripulanteViajeAjaxController;
use App\Http\Controllers\SitioPescaAjaxController;
use App\Http\Controllers\ArtePescaAjaxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportesOperativosController;
use App\Http\Controllers\CapturasController;
use App\Http\Controllers\BiologiaController;
use App\Http\Controllers\ZonasController;
use App\Http\Controllers\EconomiaController;
use App\Http\Controllers\EconomiaInsumoController;
use App\Http\Controllers\FlotaController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\AlertasController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiProxyController;
use App\Http\Controllers\ParametroAmbientalAjaxController;
use App\Http\Controllers\EconomiaInsumoAjaxController;
use App\Http\Controllers\EconomiaVentaAjaxController;
use App\Http\Controllers\DatoBiologicoAjaxController;
use App\Http\Controllers\ArchivoCapturaAjaxController;
use App\Http\Controllers\ArchivoController;

Route::get('/', function () {
    return view('home');
})->middleware('ensure.logged.in');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('ensure.logged.in');

Route::middleware('ensure.logged.in')->group(function () {
    Route::resource('embarcaciones', EmbarcacionController::class)->except(['show']);
    Route::resource('campanias', CampaniaController::class)->except(['show']);
    Route::prefix('campanias/{campania}')->group(function () {
        Route::get('tabla-multifinalitaria', [TablaMultifinalitariaController::class, 'index'])->name('campanias.tabla-multifinalitaria.index');
        Route::post('tabla-multifinalitaria', [TablaMultifinalitariaController::class, 'store'])->name('campanias.tabla-multifinalitaria.store');
        Route::put('tabla-multifinalitaria/{id}', [TablaMultifinalitariaController::class, 'update'])->name('campanias.tabla-multifinalitaria.update');
        Route::delete('tabla-multifinalitaria/{id}', [TablaMultifinalitariaController::class, 'destroy'])->name('campanias.tabla-multifinalitaria.destroy');
    });
    Route::get('ajax/campos-dinamicos', [CampaniaController::class, 'camposDinamicos']);
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
    Route::get('ajax/personas/buscar', [PersonaController::class, 'buscar'])->name('ajax.personas.buscar');
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
    Route::resource('capturas', CapturaController::class)->except(['show']);
    Route::get('ajax/capturas-viaje', [CapturaAjaxController::class, 'index'])->name('ajax.capturas-viaje');
    Route::get('ajax/capturas/{id}', [CapturaAjaxController::class, 'show'])->name('ajax.capturas.show');
    Route::post('ajax/capturas', [CapturaAjaxController::class, 'store'])->name('ajax.capturas.store');
    Route::put('ajax/capturas/{id}', [CapturaAjaxController::class, 'update'])->name('ajax.capturas.update');
    Route::delete('ajax/capturas/{id}', [CapturaAjaxController::class, 'destroy'])->name('ajax.capturas.destroy');
    Route::get('ajax/capturas/{captura}/archivos', [ArchivoCapturaAjaxController::class, 'index']);
    Route::post('ajax/capturas/{captura}/archivos', [ArchivoCapturaAjaxController::class, 'store']);
    Route::delete('ajax/archivos/{archivo}', [ArchivoCapturaAjaxController::class, 'destroy']);

    Route::get('archivos/{path}', [ArchivoController::class, 'show'])->where('path', '.*');

    Route::get('ajax/datos-biologicos', [DatoBiologicoAjaxController::class, 'index']);
    Route::get('ajax/datos-biologicos/{id}', [DatoBiologicoAjaxController::class, 'show']);
    Route::post('ajax/datos-biologicos', [DatoBiologicoAjaxController::class, 'store']);
    Route::put('ajax/datos-biologicos/{id}', [DatoBiologicoAjaxController::class, 'update']);
    Route::delete('ajax/datos-biologicos/{id}', [DatoBiologicoAjaxController::class, 'destroy']);

    Route::get('ajax/sitios-pesca', [SitioPescaAjaxController::class, 'index']);
    Route::post('ajax/sitios-pesca', [SitioPescaAjaxController::class, 'store']);
    Route::put('ajax/sitios-pesca/{id}', [SitioPescaAjaxController::class, 'update']);

    Route::get('ajax/artes-pesca', [ArtePescaAjaxController::class, 'index']);
    Route::post('ajax/artes-pesca', [ArtePescaAjaxController::class, 'store']);
    Route::put('ajax/artes-pesca/{id}', [ArtePescaAjaxController::class, 'update']);

    Route::resource('tripulantes-viaje', TripulanteViajeController::class)->except(['show']);
    Route::get('ajax/tripulantes-viaje', [TripulanteViajeAjaxController::class, 'index'])->name('ajax.tripulantes-viaje');
    Route::get('ajax/tripulantes-viaje/{id}', [TripulanteViajeAjaxController::class, 'show'])->name('ajax.tripulantes-viaje.show');
    Route::post('ajax/tripulantes-viaje', [TripulanteViajeAjaxController::class, 'store'])->name('ajax.tripulantes-viaje.store');
    Route::put('ajax/tripulantes-viaje/{id}', [TripulanteViajeAjaxController::class, 'update'])->name('ajax.tripulantes-viaje.update');
    Route::delete('ajax/tripulantes-viaje/{id}', [TripulanteViajeAjaxController::class, 'destroy'])->name('ajax.tripulantes-viaje.destroy');

    Route::resource('observadores-viaje', ObservadorViajeController::class)->except(['show']);
    Route::get('ajax/observadores-viaje', [ObservadorViajeAjaxController::class, 'index'])->name('ajax.observadores-viaje');
    Route::get('ajax/observadores-viaje/{id}', [ObservadorViajeAjaxController::class, 'show'])->name('ajax.observadores-viaje.show');
    Route::post('ajax/observadores-viaje', [ObservadorViajeAjaxController::class, 'store'])->name('ajax.observadores-viaje.store');
    Route::put('ajax/observadores-viaje/{id}', [ObservadorViajeAjaxController::class, 'update'])->name('ajax.observadores-viaje.update');
    Route::delete('ajax/observadores-viaje/{id}', [ObservadorViajeAjaxController::class, 'destroy'])->name('ajax.observadores-viaje.destroy');

    Route::get('ajax/parametros-ambientales', [ParametroAmbientalAjaxController::class, 'index'])->name('ajax.parametros-ambientales');
    Route::get('ajax/parametros-ambientales/{id}', [ParametroAmbientalAjaxController::class, 'show'])->name('ajax.parametros-ambientales.show');
    Route::post('ajax/parametros-ambientales', [ParametroAmbientalAjaxController::class, 'store'])->name('ajax.parametros-ambientales.store');
    Route::put('ajax/parametros-ambientales/{id}', [ParametroAmbientalAjaxController::class, 'update'])->name('ajax.parametros-ambientales.update');
    Route::delete('ajax/parametros-ambientales/{id}', [ParametroAmbientalAjaxController::class, 'destroy'])->name('ajax.parametros-ambientales.destroy');

    Route::resource('economia-insumo', EconomiaInsumoController::class)->except(['show']);
    Route::get('ajax/economia-insumo', [EconomiaInsumoAjaxController::class, 'index'])->name('ajax.economia-insumo');
    Route::get('ajax/economia-insumo/{id}', [EconomiaInsumoAjaxController::class, 'show'])->name('ajax.economia-insumo.show');
    Route::post('ajax/economia-insumo', [EconomiaInsumoAjaxController::class, 'store'])->name('ajax.economia-insumo.store');
    Route::put('ajax/economia-insumo/{id}', [EconomiaInsumoAjaxController::class, 'update'])->name('ajax.economia-insumo.update');
    Route::delete('ajax/economia-insumo/{id}', [EconomiaInsumoAjaxController::class, 'destroy'])->name('ajax.economia-insumo.destroy');

    Route::get('ajax/economia-ventas', [EconomiaVentaAjaxController::class, 'index'])->name('ajax.economia-ventas');
    Route::get('ajax/economia-ventas/{id}', [EconomiaVentaAjaxController::class, 'show'])->name('ajax.economia-ventas.show');
    Route::post('ajax/economia-ventas', [EconomiaVentaAjaxController::class, 'store'])->name('ajax.economia-ventas.store');
    Route::put('ajax/economia-ventas/{id}', [EconomiaVentaAjaxController::class, 'update'])->name('ajax.economia-ventas.update');

    Route::resource('menus', MenuController::class)->except(['show']);
    Route::resource('roles', RolController::class)->except(['show']);
    Route::get('rolmenu/{idrol}/{idmenu}/edit', [RolMenuController::class, 'edit'])->name('rolmenu.edit');
    Route::put('rolmenu/{idrol}/{idmenu}', [RolMenuController::class, 'update'])->name('rolmenu.update');
    Route::delete('rolmenu/{idrol}/{idmenu}', [RolMenuController::class, 'destroy'])->name('rolmenu.destroy');
    Route::resource('rolmenu', RolMenuController::class)->only(['index', 'create', 'store']);

    Route::delete('rolpersona/{idpersona}/{idrol}', [RolPersonaController::class, 'destroy'])->name('rolpersona.destroy');
    Route::resource('rolpersona', RolPersonaController::class)->only(['index', 'create', 'store']);
    Route::resource('usuarios', UsuarioController::class)->except(['show']);
});


if (!function_exists('runReporte')) {
    function runReporte(string $file) {
        $path = public_path("reportes/{$file}");
        abort_unless(is_file($path), 404, 'Reporte no encontrado');
        ob_start();
        include $path;     // ejecuta rXX.php
        return response(ob_get_clean());
    }
}

// Operativos
Route::get('/operativos/viajes', [ReportesOperativosController::class, 'viajesPeriodo'])->name('operativos.viajes');
Route::get('/operativos/esfuerzo', [ReportesOperativosController::class, 'mapaEsfuerzo'])->name('operativos.esfuerzo');
Route::get('/operativos/productividad', [ReportesOperativosController::class, 'productividadUsuarios'])->name('operativos.productividad');

// Capturas
Route::get('/capturas/top', [CapturasController::class, 'topEspecies'])->name('capturas.top');
Route::get('/capturas/composicion', [CapturasController::class, 'composicionPorViaje'])->name('capturas.composicion');
Route::get('/capturas/tallas', [CapturasController::class, 'capturasPorTamanio'])->name('capturas.tallas');

// Biología
Route::get('/biologia/tallas', [BiologiaController::class, 'estructuraTallas'])->name('biologia.tallas');
Route::get('/biologia/madurez', [BiologiaController::class, 'madurez'])->name('biologia.madurez');
Route::get('/biologia/rel-lw', [BiologiaController::class, 'relLW'])->name('biologia.rel_lw');

// Zonas
Route::get('/zonas/sitios', [ZonasController::class, 'sitiosFrecuentes'])->name('zonas.sitios');

// Economía
Route::get('/economia/viaje', [EconomiaController::class, 'resumenPorViaje'])->name('economia.viaje');
Route::get('/economia/precios', [EconomiaController::class, 'precioPromedio'])->name('economia.precios');
Route::get('/economia/margen', [EconomiaController::class, 'margen'])->name('economia.margen');
Route::get('/economia/destino', [EconomiaController::class, 'destinoVenta'])->name('economia.destino');
Route::get('/economia/insumos', [EconomiaController::class, 'costoInsumos'])->name('economia.insumos');

// Flota
Route::get('/flota/inventario', [FlotaController::class, 'inventario'])->name('flota.inventario');
Route::get('/flota/productividad', [FlotaController::class, 'productividad'])->name('flota.productividad');
Route::get('/flota/tripulacion', [FlotaController::class, 'tripulacion'])->name('flota.tripulacion');
Route::get('/flota/seguridad', [FlotaController::class, 'seguridad'])->name('flota.seguridad');

// Ejecutivos
Route::get('/kpi/mensual', [KpiController::class, 'kpiMensual'])->name('kpi.mensual');
Route::get('/kpi/top-valor', [KpiController::class, 'topValor'])->name('kpi.top_valor');
Route::get('/kpi/sostenibilidad', [KpiController::class, 'sostenibilidad'])->name('kpi.sostenibilidad');
Route::get('/kpi/operativo', [KpiController::class, 'desempenoOperativo'])->name('kpi.operativo');
Route::get('/kpi/interanual', [KpiController::class, 'interanual'])->name('kpi.interanual');
Route::get('/kpi/alertas', [AlertasController::class, 'index'])->name('kpi.alertas');

// API para mapas/gráficas
Route::get('/api/esfuerzo', [ApiController::class, 'esfuerzo'])->name('api.esfuerzo');
Route::get('/api/sitios-reporte', [ApiController::class, 'sitios'])->name('api.sitios.reporte');
Route::get('/api/serie', [ApiController::class, 'serie'])->name('api.serie');

// API proxy to external service
Route::get('/api/especies', [ApiProxyController::class, 'getEspecies'])->name('api.especies');
Route::get('/api/tipo-observador', [ApiProxyController::class, 'getTipoObservador'])->name('api.tipo-observador');
Route::get('/api/tipos-tripulante', [ApiProxyController::class, 'getTiposTripulante'])->name('api.tipos-tripulante');
Route::get('/api/estados-marea', [ApiProxyController::class, 'getEstadosMarea'])->name('api.estados-marea');
Route::get('/api/condiciones-mar', [ApiProxyController::class, 'getCondicionesMar'])->name('api.condiciones-mar');
Route::get('/api/tipos-arte', [ApiProxyController::class, 'getTiposArte'])->name('api.tipos-arte');
Route::get('/api/tipos-anzuelo', [ApiProxyController::class, 'getTiposAnzuelo'])->name('api.tipos-anzuelo');
Route::get('/api/materiales-malla', [ApiProxyController::class, 'getMaterialesMalla'])->name('api.materiales-malla');
Route::get('/api/tipos-insumo', [ApiProxyController::class, 'getTiposInsumo'])->name('api.tipos-insumo');
Route::get('/api/unidades-insumo', [ApiProxyController::class, 'getUnidadesInsumo'])->name('api.unidades-insumo');
Route::get('/api/unidades-venta', [ApiProxyController::class, 'getUnidadesVenta'])->name('api.unidades-venta');
Route::get('/api/unidades-profundidad', [ApiProxyController::class, 'getUnidadesProfundidad'])->name('api.unidades-profundidad');
Route::get('/api/unidades-longitud', [ApiProxyController::class, 'getUnidadesLongitud'])->name('api.unidades-longitud');
Route::get('/api/estados-desarrollo-gonadal', [ApiProxyController::class, 'getEstadosDesarrolloGonadal'])->name('api.estados-desarrollo-gonadal');
Route::get('/api/sitios', [ApiProxyController::class, 'getSitios'])->name('api.sitios');
Route::get('/api/personas', [ApiProxyController::class, 'getPersonas'])->name('api.personas');
Route::get('/api/personas/{id}', [ApiProxyController::class, 'getPersona'])->name('api.personas.show');
Route::get('/api/organizacion-pesquera', [ApiProxyController::class, 'getOrganizacionesPesquera'])->name('api.organizacion-pesquera');
