<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

/**
 * Creates a products from a CLI command, with a configurable stock level
 *
 * @class CreateProductWithStockCommand
 * @package App\Console\Commands
 */
class CreateProductWithStockCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'create:product-with-stock {sku} {product_name} {price} {stock} {description?}';

    /**
     * @var string
     */
    protected $description = 'Create a product with stock';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            'sku' => $this->argument('sku'),
            'product_name' => $this->argument('product_name'),
            'price' => $this->argument('price'),
            'description' => $this->argument('description') ?? '',
        ];

        $stock = (int) $this->argument('stock');

        $product = Product::create([
            'sku' => $data['sku'],
            'product_name' => $data['product_name'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
        ]);

        $this->info("Product created: {$product->product_name} with stock {$stock}");

        return 0;
    }
}
