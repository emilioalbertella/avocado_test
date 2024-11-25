<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{

    public function run()
    {
        $products = [
            [
                'sku' => 'rkt1',
                'product_name' => 'Rocket',
                'description' => 'A simple rocket',
                'price' => 95.85,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'sku' => 'swrd',
                'product_name' => 'Sword',
                'description' => 'A majestic sword',
                'price' => 15.20,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'sku' => 'pncl',
                'product_name' => 'Pencil',
                'description' => 'A nice blue pencil',
                'price' => 2.50,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'sku' => 'bsktb',
                'product_name' => 'Basketball',
                'description' => 'The best and bounciest Basketball',
                'price' => 50.00,
                'created_at' => new \DateTime(),
                'updated_at' => null,
            ]
        ];

        DB::table('products')->insert($products);
    }
}

