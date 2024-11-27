<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @class ProductFactory
 * @package Database\Factories
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->ean8(),
            'product_name' => $this->faker->word,
            'description' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 500)
        ];
    }

    /**
     * Create a fake stock after the creation of a product
     *
     * @param int|null $quantity
     * @return ProductFactory
     */
    public function withStock(?int $quantity = null)
    {
        return $this->afterCreating(function (Product $product) use ($quantity) {
            $product->stock()->create([
                'quantity' => $quantity ?? $this->faker->numberBetween(1, 100),
            ]);
        });
    }
}
