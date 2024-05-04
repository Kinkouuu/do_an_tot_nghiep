<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminAccountRequest extends FormRequest
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
            'account_name' => 'required|min:4|max:255|unique:admins,account_name,' . $this->staff?->id,
            'password' => 'required|min:6',
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|starts_with:0|digits:10|numeric',
            'citizen_id' => 'nullable|alpha_num'
        ];
    }
}
