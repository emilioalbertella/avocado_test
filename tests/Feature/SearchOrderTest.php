<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @class SearchOrderTest
 * @package Tests\Feature
 */
class SearchOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test searching orders by customer name.
     *
     * @return void
     */
    public function test_search_by_name()
    {
        $order1 = Order::create([
            'customer_name' => 'Emilio Wasss',
            'customer_address' => 'via delle cose',
            'description' => 'big order for xmas',
            'customer_email' => 'emilio@example.com',
        ]);

        $order2 = Order::create([
            'customer_name' => 'Ivan Rotto',
            'customer_address' => 'via delle cose',
            'description' => 'Order for a single pen',
            'customer_email' => 'ivan@example.com',
        ]);

        // Perform a search by customer name
        $response = $this->postJson('/api/order/search', [
            'name' => 'lio Wass',
        ]);

        // Assert that the response contains the correct order
        $response->assertStatus(200)
            ->assertJsonFragment(['customer_name' => 'Emilio Wasss'])
            ->assertJsonMissing(['customer_name' => 'Ivan Rotto']);
    }

    /**
     * Test searching orders with both name and description.
     *
     * @return void
     */
    public function test_search_by_name_and_description()
    {
        // Seed some test data
        $order1 = Order::create([
            'customer_name' => 'Emilio Wasss',
            'customer_address' => 'via delle cose',
            'description' => 'Order for a single pencil',
            'customer_email' => 'john@example.com',
        ]);

        $order2 = Order::create([
            'customer_name' => 'Ivan Rotto',
            'customer_address' => 'via delle cose',
            'description' => 'Order for a pen',
            'customer_email' => 'jane@example.com',
        ]);

        // Perform a search by both customer name and description
        $response = $this->postJson('/api/order/search', [
            'name' => 'milio',
            'description' => 'single',
        ]);

        // Assert that the response contains the correct order
        $response->assertStatus(200)
            ->assertJsonFragment(['customer_name' => 'Emilio Wasss'])
            ->assertJsonFragment(['description' => 'Order for a single pencil']);
    }

    /**
     * Test searching orders with no parameters provided.
     *
     * @return void
     */
    public function test_search_without_parameters()
    {
        // Perform a search without any parameters
        $response = $this->postJson('/api/order/search', []);

        // Assert that the response contains the appropriate error message
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'You must provide either a name or a description.',
            ]);
    }
}
