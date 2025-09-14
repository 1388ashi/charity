<?php

namespace Modules\Area\App\Http\Requests\Admin\City;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $cityId = Helpers::getModelIdOnPut('city');

        return  [
            'name' => ["required","string","unique:cities,id," . $cityId],
            'province_id' => ["required","exists:provinces,id"],
            'user_id' => ["required","exists:users,id"],
            'status' => ["nullable","boolean"],

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
