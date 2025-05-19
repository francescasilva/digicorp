<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

// Ruta de inicio - Redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Ruta del formulario de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Ruta para procesar el login
Route::post('/login', [AuthController::class, 'login']);

// Ruta para productos  
Route::get('/products', [ProductController::class, 'index'])->name('products');
