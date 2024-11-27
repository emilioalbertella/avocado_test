<?php
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';

// Bootstrap the application to access Eloquent
use Illuminate\Contracts\Console\Kernel;
$app->make(Kernel::class)->bootstrap();

use App\Models\Product;

function createProductWithStock(array $productData, int $stockAmount)
{
    $product = Product::create($productData);

    $product->stock()->create([
        'quantity' => $stockAmount,
    ]);

    return $product;
}

/** @var Product $product */
$product = createProductWithStock([
        'sku'         => 'xyz123',
        'product_name'        => 'Product with stock',
        'description' => 'A test product with stock ',
        'price'       => 29.99
    ], 25
);


// Debug
//dd($product->load('stock'));
