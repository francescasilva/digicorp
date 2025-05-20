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
            'image' => 'https://canon.ptmarket.com.pe/pub/media/catalog/product/cache/ca0302599d2357389b0418ee686725c5/d/_/d_nq_np_720836-mpe31254862052_062019-o.jpeg', // URL de ejemplo
        ]);

        Product::create([
            'name' => 'Producto B',
            'quantity' => 5,
            'price' => 50.00,
            'image' => 'https://canon.ptmarket.com.pe/pub/media/catalog/product/cache/ca0302599d2357389b0418ee686725c5/d/_/d_nq_np_720836-mpe31254862052_062019-o.jpeg',
        ]);

        Product::create([
            'name' => 'Producto c',
            'quantity' => 2,
            'price' => 200.00,
            'image' => 'https://canon.ptmarket.com.pe/pub/media/catalog/product/cache/ca0302599d2357389b0418ee686725c5/d/_/d_nq_np_720836-mpe31254862052_062019-o.jpeg',
        ]);

        Product::create([
            'name' => 'Producto D ',
            'quantity' => 9,
            'price' => 250.00,
            'image' => 'https://canon.ptmarket.com.pe/pub/media/catalog/product/cache/ca0302599d2357389b0418ee686725c5/d/_/d_nq_np_720836-mpe31254862052_062019-o.jpeg',
        ]);

        Product::create([
            'name' => 'Producto E',
            'quantity' => 3,
            'price' => 60.00,
            'image' => 'https://canon.ptmarket.com.pe/pub/media/catalog/product/cache/ca0302599d2357389b0418ee686725c5/d/_/d_nq_np_720836-mpe31254862052_062019-o.jpeg',
        ]);
    }
}
