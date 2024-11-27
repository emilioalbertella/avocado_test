<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DateRangeRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderDeleteRequest;
use App\Http\Requests\OrderGetRequest;
use App\Interfaces\OrderItemServiceInterface;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    protected ProductServiceInterface $productService;
    /**
     * @var OrderItemServiceInterface
     */
    private OrderItemServiceInterface $orderItemService;
    /**
     * @var OrderServiceInterface
     */
    private OrderServiceInterface $orderService;

    /**
     * @param ProductServiceInterface $productService
     * @param OrderItemServiceInterface $orderItemService
     * @param OrderServiceInterface $orderService
     */
    public function __construct(
        ProductServiceInterface $productService,
        OrderItemServiceInterface $orderItemService,
        OrderServiceInterface $orderService
    ) {
        $this->productService = $productService;
        $this->orderItemService = $orderItemService;
        $this->orderService = $orderService;
    }

    /**
     * Creates a new order
     *
     * @param OrderCreateRequest $request
     * @return mixed
     */
    public function create(OrderCreateRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(
            function () use ($validated) {
                $customerId = $validated['customer_id'] ?? null;

                // Create the order
                // We use payload values. The stored data can be used maybe by the FE to fulfill the checkout
                // fields but the customer should be free to change data on the order
                $order = Order::create([
                    'customer_id' => $customerId,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_address' => $validated['customer_address'],
                    'customer_phone' => $validated['customer_address'],
                    'description' => $validated['description'] ?? null,
                    'status' => Order::ORDER_STATUS_PENDING,
                ]);

                $total = 0;
                foreach ($validated['items'] as $item) {
                    /** @var Product $product */
                    $product = Product::findOrFail($item['product_id']);
                    $total += $product->price * $item['quantity'];

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

                // update total on the Order, we couldn't before because we had to save first the Order
                // before the Order Items to be able to use its Order ID
                $order->update(['total' => $total]);

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

    /**
     * Deletes an order by its ID.
     *
     * @param OrderDeleteRequest $request
     * @return JsonResponse
     */
    public function delete(OrderDeleteRequest $request)
    {
        $validated = $request->validated();

        $orderId = $validated['id'];
        $hardDelete = $validated['hard_delete'] ?? false;

        // Check if the order exists
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // if the order exists, it's already Cancelled and we don't need to hard delete it, return
        if ($order->status === Order::ORDER_STATUS_CANCELLED && !$hardDelete) {
            return response()->json(['message' => 'Order is already Cancelled']);
        }

        return DB::transaction(function () use ($order, $hardDelete) {
            if ($order->status === Order::ORDER_STATUS_PENDING) {
                // Restore stock for each Order Item related to the Order
                foreach ($order->items as $item) {
                    $item->product->stock()->increment('quantity', $item->quantity);
                }
            }

            if ($hardDelete) {
                $this->orderItemService->deleteAllOrderItems($order->id);
                $order->delete();

                return response()->json(
                    ['message' => 'Order and associated Items have been deleted permanently'],
                    200
                );
            }

            $order->update(['status' => Order::ORDER_STATUS_CANCELLED]);

            return response()->json(
                ['message' => 'Order have been marked as Cancelled'],
                200
            );
        });
    }

    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function show($order_id)
    {
        try {
            // Find the order by ID, with related order items
            $order = Order::with('items.product')->findOrFail($order_id);

            // Return the order data
            return response()->json([
                'order' => $order
            ], 200);

        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
    }

    /**
     * @param DateRangeRequest $request
     * @return JsonResponse
    */
    public function getOrderByDateRange(DateRangeRequest $request)
    {
        $validated = $request->validated();

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        $orders = $this->orderService->getOrdersBetweenDates($startDate, $endDate) ?? [];

        return response()->json([
                'message' => $orders->count() . ' Order' . ($orders->count() === 1 ? '' : 's') . ' found',
                'orders' => $orders
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        if ($validated === []) {
            return response()->json([
                'message' => 'You must provide either a name or a description.',
            ], 400);
        }

        $name = $validated['name'] ?? null;
        $description = $validated['description'] ?? null;

        $orders = $this->orderService->searchOrdersByNameDescription($name, $description) ?? [];

        return response()->json($orders, 200);
    }
}
