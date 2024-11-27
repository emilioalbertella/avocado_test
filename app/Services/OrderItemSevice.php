<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\OrderItemServiceInterface;
use App\Models\OrderItem;

/**
 * @class OrderItemSevice
 * @package App\Services
 */
class OrderItemSevice implements OrderItemServiceInterface
{
    /**
     * Get all Order Items of an Order, from the Order ID
     *
     * @param int $orderId
     * @return mixed
     */
    public function getAllOrderItems(int $orderId)
    {
        return OrderItem::where('order_id', $orderId)->get();
    }

    /**
     * Delete all Order Items of an Order
     *
     * @param int $orderId
     * @return mixed
     */
    public function deleteAllOrderItems(int $orderId)
    {
        return OrderItem::where('order_id', $orderId)->delete();
    }

    /**
     * Get a specific order item by ID.
     *
     * @param int $orderItemId
     * @return mixed
     */
    public function getOrderItemById(int $orderItemId)
    {
        return OrderItem::findOrFail($orderItemId);
    }

    /**
     * Create a new order item.
     *
     * @param array $data
     * @return mixed
     */
    public function createOrderItem(array $data)
    {
        return OrderItem::create($data);
    }

    /**
     * @param int $orderItemId
     * @param array $data
     * @return mixed
     */
    public function updateOrderItem(int $orderItemId, array $data)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);
        $orderItem->update($data);

        return $orderItem;
    }

    /**
     * Delete an order item.
     *
     * @param int $orderItemId
     * @return mixed
     */
    public function deleteOrderItem(int $orderItemId)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);

        return $orderItem->delete();
    }
}
