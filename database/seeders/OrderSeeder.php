<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'user_id' => null,
                'customer_email' => 'alberto@gmail.com',
                'customer_name' => 'alberto emiliella',
                'customer_address' => 'fake address number 1',
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'user_id' => null,
                'customer_email' => 'emilio@cose.com',
                'customer_name' => 'emilio albertella',
                'customer_address' => 'fake address number 2',
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'user_id' => '1',
                'customer_email' => 'nicholasb@gmail.it',
                'customer_name' => 'Nicholas Bale',
                'customer_address' => '1200 17th Street, Floor 15, Denver CO',
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'user_id' => null,
                'customer_email' => 'missilo@rocket.com',
                'customer_name' => 'raiku madlaine',
                'customer_address' => 'fake address number 1',
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
