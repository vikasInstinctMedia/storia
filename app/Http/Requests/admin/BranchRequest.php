<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:branches',
            'city' => 'required',
            'state' => 'required',
            'prefix' => 'required|unique:branches',
            'address' => 'required|unique:branches',
            'pincode' => 'required|unique:branches',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required',
        ];
    }
}
