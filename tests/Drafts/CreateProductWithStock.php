<?php

use App\Models\Product;

/** @var Product $product */
$product = Product::create(
    [
        'sku'         => 'xyz123',
        'name'        => 'Product with stock',
        'description' => 'A test product with stock ',
        'price'       => 29.99,
    ]
);

$product->stock()->create(
    [
        'quantity' => 100,
    ]
);

// Debug
dd($product->load('stock'));
