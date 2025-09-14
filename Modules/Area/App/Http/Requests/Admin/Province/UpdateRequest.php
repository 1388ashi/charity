<?php

namespace Modules\Area\App\Http\Requests\Admin\Province;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $provinceId = Helpers::getModelIdOnPut('province');

        return  [
            'name' => ["required","string","unique:provinces,id," . $provinceId],
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
