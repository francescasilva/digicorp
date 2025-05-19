<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
{
    return view('product');  // Ahora apunta a product.blade.php directamente
}

}
