<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @class OrderRequest
 * @package App\Http\Requests
 */
class OrderCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Rules used for payload validation
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'customer_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string',
            'description' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'customer_name.required' => 'Customer Name is required',
            'customer_email.required' => 'Customer Email is required',
            'customer_address.required' => 'Customer Address is required',
            'customer_phone.required' => 'Customer Phone is required',
            'items.required' => 'Order Items are required'
        ];
    }
}
