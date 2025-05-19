<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');  // Esto buscará la vista en resources/views/login.blade.php
    }

    public function login(Request $request)
    {
        // Aquí luego pondremos el código para autenticar al usuario.
        return redirect('/dashboard');
    }

    public function dashboard()
    {
        return view('dashboard');  // Esto buscará la vista en resources/views/dashboard.blade.php
    }
}
