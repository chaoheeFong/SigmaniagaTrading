<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => '100 LED', 'sku' => 'SML-001', 'price' => 7, 'cost' => 5.08],
            ['name' => 'KeyChain', 'sku' => 'KL-001P', 'price' => 6, 'cost' => 2.36],
            ['name' => 'Wall Lamp', 'sku' => 'SWL-006', 'price' => 8, 'cost' => 4.88],
            ['name' => '120 LED', 'sku' => 'SSL-002', 'price' => 17, 'cost' => 11.84],
            ['name' => 'Foot Massage', 'sku' => 'FLR-001', 'price' => 8, 'cost' => 4.7],
            ['name' => 'EMS PAD', 'sku' => 'FEL-003', 'price' => 8, 'cost' => 2.78],
            ['name' => 'Fairy Lamp', 'sku' => 'HFL-002Colour-100LED', 'price' => 11.5, 'cost' => 5.96],
            ['name' => 'Jubah', 'sku' => 'SSL-011', 'price' => 14, 'cost' => 8.32],
            ['name' => '108COB LAMP', 'sku' => 'HNL-003WW', 'price' => 4.5, 'cost' => 2.3],
            ['name' => 'LEDLIGHT SENSOR', 'sku' => 'CCTV-002', 'price' => 15, 'cost' => 9.54],
            ['name' => 'CCTV LAMP', 'sku' => 'HTL-009', 'price' => 5.5, 'cost' => 4.87],
            ['name' => 'SHARK Torchlight', 'sku' => 'XYJQJJ-125G', 'price' => 3.5, 'cost' => 0.88],
            ['name' => 'Washing Machine', 'sku' => 'HTL-003', 'price' => 6, 'cost' => 4.75],
            ['name' => 'Torchlight', 'sku' => 'HAC-001', 'price' => 17, 'cost' => 12.87],
            ['name' => 'Aircooler', 'sku' => 'HHL-001', 'price' => 4.5, 'cost' => 3.57],
            ['name' => 'HeadLamp', 'sku' => 'MS-001', 'price' => 1.8, 'cost' => 0.89],
            ['name' => 'Stokin', 'sku' => 'MS-002', 'price' => 1.8, 'cost' => 0.89], // Updated SKU to avoid duplication
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'product_name' => $product['name'],
                'product_sku' => $product['sku'],
                'product_price' => $product['price'],
                'product_cost' => $product['cost'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
