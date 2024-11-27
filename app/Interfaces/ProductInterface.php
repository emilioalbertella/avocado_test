<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @interface
 */
interface ProductInterface
{
    /**
     * Returns all the orders containing the product
     *
     * @return BelongsToMany
     */
    public function orders();

    /**
     * Returns the stock of the product
     * @return HasOne
     */
    public function stock();

}
