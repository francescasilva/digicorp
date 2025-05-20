<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'LAPTOP HP',
            'quantity' => 10,
            'price' => 1800.00,
            'image' => 'https://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c08484411.png', // URL de ejemplo
        ]);

        Product::create([
            'name' => 'IMPRESORA EPSON ',
            'quantity' => 10,
            'price' => 1200.00,
            'image' => 'https://www.infotec.com.pe/43524-thickbox_default/impresora-epson-l14150-c11ch95303-a3-wifi-multifuncional.jpg ', // URL de ejemplo
        ]);

        Product::create([
            'name' => 'CELULAR APPLE IPHONE',
            'quantity' => 2,
            'price' => 4000.00,
            'image' => 'https://icon.co.cr/cdn/shop/files/IMG-14858901_0aa44622-fc16-428d-a2fe-602d2d649fd2.jpg?v=1729269557&width=823',
        ]);

        Product::create([
            'name' => 'TABLET LENOVO',
            'quantity' => 9,
            'price' => 800.00,
            'image' => 'https://www.lacuracao.pe/media/catalog/product/p/s/ps31120946_1.jpg?quality=80&bg-color=255,255,255&fit=bounds&height=700&width=700&canvas=700:700',
        ]);

        Product::create([
            'name' => 'CÁMARA CANON',
            'quantity' => 9,
            'price' => 3000.00,
            'image' => 'https://i1.adis.ws/i/canon/eos-m200_bk_3847d7555e7f4c5ba9cb90c0cfb49dcb?$prod-gallery-1by1$',
        ]);
        Product::create([
            'name' => 'MOUSE ITEC',
            'quantity' => 9,
            'price' => 50.00,
            'image' => 'https://production-tailoy-repo-magento-statics.s3.amazonaws.com/imagenes/872x872/productos/i/m/o/mouse-itec-int-ll189-wireless-rosado-62229004-default-1.jpg',
        ]);
        Product::create([
            'name' => 'CARGADOR IPHONE',
            'quantity' => 9,
            'price' => 80.00,
            'image' => 'https://m.media-amazon.com/images/I/317N2kz2zzL._AC_.jpg',
        ]);
        Product::create([
            'name' => 'SILLA GAMER ELITE Roja',
            'quantity' => 9,
            'price' => 1800.00,
            'image' => 'https://www.proshopper.pe/cdn/shop/products/5_bb6cf308-7cd7-4634-9d4f-aaf178a078e5_1024x1024.jpg?v=1612460526',
        ]);
        Product::create([
            'name' => 'PLAYSTATION 4',
            'quantity' => 9,
            'price' => 4000.00,
            'image' => 'https://gmedia.playstation.com/is/image/SIEPDC/ps4-slim-image-block-01-en-24jul20?$1600px--t$',
        ]);
         Product::create([
            'name' => 'COOLER ENFRIADOR',
            'quantity' => 9,
            'price' => 600.00,
            'image' => 'https://promart.vteximg.com.br/arquivos/ids/5896058-1000-1000/image-2f4263495d714b4c8219083fae9ca28f.jpg?v=637886890588600000',
        ]);
         Product::create([
            'name' => 'SCOOTER ELECTRICO',
            'quantity' => 9,
            'price' => 1600.00,
            'image' => 'https://www.datacont.com/web/image/product.product/3333/image_1024/%5BTUES9VE2PLUS%5D%20SCOOTER%20ELECTRICO%20SEGWAY%20NINEBOT%20E2%20PLUS%20%20051402U?unique=2aeb8ca',
        ]);
         Product::create([
            'name' => 'DRONE DJI ',
            'quantity' => 9,
            'price' => 2900.00,
            'image' => 'https://cdnx.jumpseller.com/killstore/image/47403692/resize/610/610?1718121230',
        ]);
        
    }
}
