<?php

use App\Models\Product;

$product = new Product();
$product->sku = 'rckt1';
$product->name = 'Rocket';
$product->description = 'A simple rocket';
$product->price = 99.99;
$product->save();
