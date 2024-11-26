<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @class OrderRequest
 * @package App\Http\Requests
 */
class OrderDeleteRequest extends AbstractGetOrder
{
    /**
     * Rules used for payload validation
     *
     * @return string[]
     */
    public function rules()
    {
        return parent::rules() + ['hard_delete' => 'boolean'];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return parent::messages()
            + ['hard_delete.boolean' => 'Order Hard Delete should be a boolean value.'];
    }
}
