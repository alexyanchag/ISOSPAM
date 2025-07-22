<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmbarcacionController;

Route::get('/', function () {
    return view('home');
})->middleware('ensure.logged.in');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('ensure.logged.in');

Route::middleware('ensure.logged.in')->group(function () {
    Route::resource('embarcaciones', EmbarcacionController::class)->except(['show']);
});
