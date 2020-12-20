<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'total_customer' => 'in:100000,50000,20000,10000,5000,1000,500,200,100,50|required|integer',
            'purchase_total' => 'in:100000,50000,20000,10000,5000,1000,500,200,100,50|required|integer'
        ];
    }
}
