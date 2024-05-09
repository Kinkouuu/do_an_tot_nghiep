<?php

namespace App\Http\Requests\Admin;

use App\Enums\Service\ServiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'name' => 'required|max:255|string',
            'description' => 'nullable|max:1000|string',
            'price' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(ServiceStatus::asArray())]
        ];
    }
}
