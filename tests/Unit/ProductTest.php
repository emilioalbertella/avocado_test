<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCreateProduct()

    {

        $data = [

            'name' => "New Product",

            'description' => "This is a product",

            'units' => 20,

            'price' => 10,

            'image' => "https://images.pexels.com/photos/1000084/pexels-photo-1000084.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"

        ];

        $user = factory(\App\Model\User::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/products',$data);
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Product Created!"]);
        $response->assertJson(['data' => $data]);

    }
}
