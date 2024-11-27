<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @class CreateOrderTest
 */
class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Create some Products with factory and test the creation of an Order
     *
     * @return void
     */
    public function test_order_creation_without_customer_id()
    {
        $product = Product::factory()->withStock(100)->create();

        $payload = [
            'customer_email' => 'test@example.com',
            'customer_name' => 'Gianbruco',
            'customer_address' => '123 Test Street',
            'customer_phone' => '1666-10-10-10',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 3
                ],
            ],
        ];

        $response = $this->postJson('/api/order/create', $payload);

        // assert response status is successful
        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'order_id']);

        // assert we created the order with customer_id = 0
        $this->assertDatabaseHas('orders', [
            'customer_email' => 'test@example.com',
            'customer_address' => '123 Test Street',
            'customer_id' => null,
        ]);

        // assert the stock has been deducted
        $this->assertDatabaseHas('inventory', [
            'product_id' => $product->id,
            'quantity' => 97,
        ]);


    }
}
