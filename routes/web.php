<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmbarcacionController;
use App\Http\Controllers\CampaniaController;
use App\Http\Controllers\PuertoController;

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
});
