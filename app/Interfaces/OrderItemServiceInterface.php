<?php
declare(strict_types=1);

namespace App\Interfaces;

/**
 * @interface
 */
interface OrderItemServiceInterface
{
    /**
     * @param int $orderId
     * @return mixed
     */
    public function getAllOrderItems(int $orderId);

    /**
     * @param int $orderItemId
     * @return mixed
     */
    public function getOrderItemById(int $orderItemId);

    /**
     * Delete all Order Items of an Order
     *
     * @param int $orderId
     * @return mixed
     */
    public function deleteAllOrderItems(int $orderId);

    /**
     * @param array $data
     * @return mixed
     */
    public function createOrderItem(array $data);

    /**
     * @param int $orderItemId
     * @param array $data
     * @return mixed
     */
    public function updateOrderItem(int $orderItemId, array $data);

    /**
     * @param int $orderItemId
     * @return mixed
     */
    public function deleteOrderItem(int $orderItemId);
}
