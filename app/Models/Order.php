<?php
declare(strict_types=1);

namespace App\Models;

use App\Interfaces\OrderInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @class Order
 * @package App\Models
 * @property int $id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_address
 * @property string $customer_phone
 * @property double $total
 * @property string $status
 */
class Order extends Model implements OrderInterface
{
    /** @var string(s)  */
    public const ORDER_STATUS_PENDING = 'pending';
    public const ORDER_STATUS_SHIPPED = 'shipped'; // for future store management purpose
    public const ORDER_STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_address',
        'customer_phone',
        'description',
        'status',
        'total'
    ];

    /**
     * Get the items associated with the order.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Retrieve Customer
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
