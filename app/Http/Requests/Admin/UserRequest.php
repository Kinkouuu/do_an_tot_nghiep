<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => [
                'sometimes', 'required', 'email', 'max:255',
                'unique:users,email,' . $this->user->id,
            ],
            'phone' => ['sometimes', 'required', 'numeric', 'starts_with:0', 'digits:10',
                'unique:users,phone,' . $this->user->id,
            ],
            'name' => 'required|max:255',
            'address' => 'required|string',
            'country' => 'required|string',
            'citizen_id' => 'required|alpha_num|unique:customers,citizen_id,'. $this->user->customer?->id,
            'birth_day' => 'required|date',
        ];
    }
}
