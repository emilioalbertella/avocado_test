<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class CreateOrderRequest
 * @package App\Http\Requests
 */
class CreateOrderRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'customer_email' => 'email',
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
