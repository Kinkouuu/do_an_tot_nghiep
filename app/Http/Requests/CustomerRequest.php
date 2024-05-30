<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'email' => 'required|email|max:255',
           'name' => 'required|max:255',
            'address' => 'required|string',
            'country' => 'required|string',
            'citizen_id' => 'required|alpha_num',
            'birth_day' => 'required|date|before_or_equal:' . now()->subYears(18),
        ];
    }

    public function messages()
    {
       return [
           'before_or_equal' => 'Bạn phải trên 18 tuổi. (Nếu không, bạn cần có người giám hộ đi cùng)'
       ];
    }
}
