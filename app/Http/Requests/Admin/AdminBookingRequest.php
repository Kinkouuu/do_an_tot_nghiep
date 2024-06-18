<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminBookingRequest extends FormRequest
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
            'rooms' => 'required|array',
            'checkin' => 'required',
            'checkout' => 'required|after:checkin',
            'user_id' => 'nullable|numeric',
            'phone' => 'required|numeric|starts_with:0|digits:10',
            'name' => 'required|max:255',
            'country' => 'required|string',
            'citizen_id' => 'required|alpha_num',
            'adults' => 'required|numeric|min:1',
            'children' => 'required|numeric|min:0',
            'note' => 'nullable|max:50'
        ];
    }
}
