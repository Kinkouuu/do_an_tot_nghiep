<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone' => 'required|numeric|starts_with:0|digits:10',
            'password' => 'required|min:6'
        ];
    }
}
