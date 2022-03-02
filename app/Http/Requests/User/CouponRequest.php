<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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

    public function rules()
    {
        return [
            'code'        => ['required', 'exists:coupons,code',  ]
        ];
    }
    
    public function messages()
    {
        return [
            'code.exists' => 'Coupon Not found'
        ];
    }
}
