<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     *Create orders without Items
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'customer_id' => null,
                'customer_email' => 'alberto@gmail.com',
                'customer_name' => 'alberto emiliella',
                'customer_address' => 'fake address number 1',
                'status' => Order::ORDER_STATUS_CANCELLED,
                'total' => 1000,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'customer_id' => null,
                'customer_email' => 'emilio@cose.com',
                'customer_name' => 'emilio albertella',
                'customer_address' => 'fake address number 2',
                'status' => Order::ORDER_STATUS_SHIPPED,
                'total' => 666,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'customer_id' => '1',
                'customer_email' => 'nicholasb@gmail.it',
                'customer_name' => 'Nicholas Bale',
                'customer_address' => '1200 17th Street, Floor 15, Denver CO',
                'status' => Order::ORDER_STATUS_PENDING,
                'total' => 7878,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'customer_id' => null,
                'customer_email' => 'missilo@rocket.com',
                'customer_name' => 'raiku madlaine',
                'customer_address' => 'fake address number 1',
                'status' => Order::ORDER_STATUS_PENDING,
                'total' => 2,
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
