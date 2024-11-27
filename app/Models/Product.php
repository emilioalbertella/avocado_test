<?php
declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @class Product
 * @package App\Models
 * @property int $id
 * @property string $sku
 * @property string $product_name
 * @property string $description
 * @property double $price
 */
class Product extends Model implements ProductInterface
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'product_name',
        'description',
        'price'
    ];

    /**
     * Returns all the orders containing the product
     *
     * @return BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot(
                'quantity'
            )->withTimestamps();
    }

    /**
     * Returns the stock of the product
     * TODO to manage differently in case of multi-stock
     * @return HasOne
     */
    public function stock()
    {
        return $this->hasOne(Inventory::class);
    }
}
