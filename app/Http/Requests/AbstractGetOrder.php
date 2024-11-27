<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @class AbstractGetOrder
 * @package App\Http\Requests
 */
abstract class AbstractGetOrder extends FormRequest
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
            'id' => 'required|integer',//|exists:orders,id',
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
            'id.required' => 'Order Id is required.',
            'id.integer' => 'Order Id shoud be integer.',
            // we'll check this later programmatically
            //'id.exists:orders,id' => 'Order ID exists in Orders Table.',
        ];
    }
}
