<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @class CreateProductWithStock
 * @package Tests\Feature
 */
class CreateProductWithStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test Create a Product with stock
     */
    public function testCreateProductWithStock()
    {
        /** @var Product $product */
        $product = Product::create(
            [
                'sku'          => 'test-sku',
                'product_name' => 'Ammo',
                'description'  => 'Ammo description',
                'price'        => 12.90,
            ]
        );

        $product->stock()->create(
            [
                'quantity' => 70,
            ]
        );

        $this->assertDatabaseHas('products', ['product_name' => 'Ammo']);
        $this->assertDatabaseHas(
            'inventory',
            [
                'quantity'   => 70,
                'product_id' => $product->id
            ]
        );
    }
}
