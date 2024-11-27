<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @interface
 */
interface OrderInterface
{
    /**
     * Returns all items in the Order
     * @return HasMany
     */
    public function items(): HasMany;

    /**
     * Retrieve Customer
     * @return BelongsTo
     */
    public function user(): BelongsTo;
}
