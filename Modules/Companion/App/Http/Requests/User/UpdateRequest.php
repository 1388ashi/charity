<?php

namespace Modules\Companion\App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $companionId = Helpers::getModelIdOnPut('companion');

        return [
            'name' => ["required","string"],
            'national_code' => ["required","string","digits:10","unique:companions,national_code," . $companionId],
            'mobile' => ["required","string","digits:11","unique:companions,mobile," . $companionId],
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
