<?php
declare(strict_types=1);

namespace App\Interfaces;

/**
 * @interface
 */
interface ProductServiceInterface
{
    /**
     * Returns all catalog Products
     * @return mixed
     */
    public function getAllProducts();

    /**
     * @param int $productId
     * @return mixed
     */
    public function getProductById(int $productId);

    /**
     * @param array $data
     * @return mixed
     */
    public function createProduct(array $data);

    /**
     * @param int $productId
     * @param array $data
     * @return mixed
     */
    public function updateProduct(int $productId, array $data);

    /**
     * @param int $productId
     * @return mixed
     */
    public function deleteProduct(int $productId);
}
