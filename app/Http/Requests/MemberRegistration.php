<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRegistration extends FormRequest
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
            'nim' => 'required|size:9|unique:profiles,nim|regex:/[0-9]{4}3[0-9]{4}/',
            'name' => 'required|string',
            'email' => 'required|email|unique:profiles,email',
            'handphone' => 'required|string|unique:profiles,handphone',
            'address' => 'required|string',
            'birthday' => 'required|string',
            'sex' => 'required'
        ];
    }
}
