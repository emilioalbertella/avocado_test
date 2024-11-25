<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @class Inventory
 * @package App\Models
 */
class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    public $timestamps = false;

    protected $fillable = ['product_id', 'quantity'];

    /**
     * Returns the Product Model of the stock
     *
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
