<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

/**
 * @class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * Saves a new order
     *
     * @param CreateOrderRequest $request
     * @return mixed
     */
    public function create(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(
            function () use ($validated) {
                $customerId = $validated['customer_id'] ?? 0;

                // Create the order
                // We won't load the user's data stored in the DB but instead use what we received
                // in the payload. The stored data can be used maybe by the FE to fulfill the checkout
                // fields but the customer should be free to change data on the order
                $order = Order::create([
                    'customer_id' => $customerId,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_address' => $validated['customer_address'],
                    'customer_phone' => $validated['customer_address'],
                    'status' => Order::ORDER_STATUS_PENDING,
                ]);

                foreach ($validated['items'] as $item) {
                    /** @var Product $product */
                    $product = Product::findOrFail($item['product_id']);

                    $productStock = 0;
                    try {
                        $productStock = $product->stock()->getResults()->quantity;
                    } catch (\Exception $exception) {
                        $productStock = 0;
                    }

                    if ($productStock < $item['quantity']) {
                        return response()->json(
                            [
                                'message' => "Insufficient stock for product ID {$product->id}"
                            ],
                            422
                        );
                    }

                    // Deduct stock
                    $product->stock()->decrement('quantity', $item['quantity']);

                    // Create order item
                    OrderItem::create(
                        [
                            'order_id'   => $order->id,
                            'product_id' => $item['product_id'],
                            'quantity'   => $item['quantity'],
                            'price'      => $product->price,
                        ]
                    );
                }

                return response()->json(
                    [
                        'message'  => 'Order created successfully',
                        'order_id' => $order->id,
                    ],
                    201
                );
            }
        );
    }
}
