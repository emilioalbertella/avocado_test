<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @class ProductCreationTest
 * @package Tests\Feature
 */
class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Test that a simple product creation Works
     */
    public function testSimpleProductInsertion()
    {
        $data = [
            'sku' => '123',
            'product_name' => 'Speaker',
            'description' => 'This is a test product.',
            'price' => 29.99
        ];

        $product = Product::create($data);

        // check if a product with given data has been created in the database
        $this->assertDatabaseHas('products', $data);

        // check if the created product has the given product_name
        $this->assertEquals('Speaker', $product->product_name);
    }
}
