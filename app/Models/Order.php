<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Order
 * @package App\Models
 */
class Order extends Model
{
    public const ORDER_STATUS_PENDING = 'pending';
    public const ORDER_STATUS_SHIPPED = 'SHIPPED';

    protected $fillable = ['customer_id', 'customer_name', 'customer_email', 'customer_address', 'customer_phone', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(OrderItem::class, 'order_items', 'order_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Retrieve Customer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
