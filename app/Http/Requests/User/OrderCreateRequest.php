<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname'        => '',
            'lastname'         => '',
            'customer_country' => '',
            'customer_state'   => '',
            'city'             => '',
            'address'          => '',
            'zip'              => '',
            'phone'            => '',
            'address'          => '',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
