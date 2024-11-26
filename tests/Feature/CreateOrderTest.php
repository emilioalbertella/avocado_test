<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @class CreateOrderTest
 */
class CreateOrderTest extends TestCase
{
    /**
     * Create some Products with factory and test the creation of an Order
     *
     * @return void
     */
    public function test_order_creation_existing_customer()
    {
        $product = Product::factory()->withStock(100)->create();

        $payload = [
            'customer_email' => 'test@example.com',
            'customer_name' => 'Gianbruco',
            'customer_address' => '123 Test Street',
            'customer_phone' => '1666-10-10-10',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 3],
            ],
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'order_id']);

        $this->assertDatabaseHas('orders', [
            'customer_email' => 'test@example.com',
            'customer_address' => '123 Test Street',
            'customer_id' => 0,
        ]);
    }
}
