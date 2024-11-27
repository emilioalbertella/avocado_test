<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\ProductServiceInterface;
use App\Models\Product;

/**
 * @class ProductService
 * @package App\Services
 */
class ProductService implements ProductServiceInterface
{
    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts()
    {
        return Product::all();
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getProductById(int $productId)
    {
        return Product::findOrFail($productId);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    /**
     * @param int $productId
     * @param array $data
     * @return mixed
     */
    public function updateProduct(int $productId, array $data)
    {
        $product = Product::findOrFail($productId);
        $product->update($data);
        return $product;
    }

    /**
     * Delete a product
     *
     * @param int $productId
     * @return mixed
     */
    public function deleteProduct(int $productId)
    {
        $product = Product::findOrFail($productId);

        return $product->delete();
    }
}
