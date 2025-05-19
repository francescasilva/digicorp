<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Ruta de inicio - Redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Ruta del formulario de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Ruta para procesar el login
Route::post('/login', [AuthController::class, 'login']);

// Ruta del dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
