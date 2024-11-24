<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var mixed|string
     */

    protected $fillable = [
        'sku',
        'product_name',
        'description',
        'price'
    ];

    /**
     * return all order containing the product
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
