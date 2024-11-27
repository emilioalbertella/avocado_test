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
class DateRangeRequest extends FormRequest
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
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
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
            'start_date.date' => 'Start Date should be a Date',
            'end_date.date' => 'End Date should be a Date',
            'end_date.required' => 'Customer Address is required',
            'end_date.after_or_equal:start_date' => 'End Date should be after or equal to Start Date',
        ];
    }
}
