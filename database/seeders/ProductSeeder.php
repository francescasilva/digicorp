<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Producto A',
            'quantity' => 10,
            'price' => 100.00,
        ]);

        Product::create([
            'name' => 'Producto B',
            'quantity' => 5,
            'price' => 50.00,
        ]);
    }
}
