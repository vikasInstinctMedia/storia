<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required',
            'category_ids' => 'required',
            'packs'       => 'required',
            'slug'        => 'unique:products,slug,'.$this->request->get('product_id'),
            'price'       => 'required|numeric|gt:0',
            // 'price_without_discount' => 'numeric|gte:0',
            'quantity'    => 'numeric|gt:0',
            // 'sku'         => 'required',
            // 'nutritional_information' => 'required',

            'banner_image'      => ['sometimes', 'required', 'mimes:jpeg,jpg,png', 'max:2048' ],
            'thumbnail_image[]'   => ['sometimes', 'required', 'mimes:jpeg,jpg,png', 'max:2048' ],
            'meta_image'        => ['sometimes', 'required', 'mimes:jpeg,jpg,png', 'max:2048' ],
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'A name is required',
            'packs.required' => 'Select at least one pack',
        ];
    }
}
