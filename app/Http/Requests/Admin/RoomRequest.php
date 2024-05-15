<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
        $branch_id = $this->get('branch_id');
        $id = $this->room?->id;
        return [
            'name' => ['required', 'alpha_dash:',
                Rule::unique('rooms')->where(function ($query) use ($branch_id, $id) {
                    return $query->where('branch_id', $branch_id)->where('id','<>', $id);
                }),
                ],
            'description' => 'nullable|max:500'
        ];
    }
}
