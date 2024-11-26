<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @class InventoryFactory
 * @package Database\Factories
 */
class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
