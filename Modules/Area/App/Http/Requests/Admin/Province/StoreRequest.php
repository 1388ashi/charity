<?php

namespace Modules\Area\App\Http\Requests\Admin\Province;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return  [
            'name' => ["required","string","unique:provinces"],
            'status' => ["nullable","boolean"],
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
