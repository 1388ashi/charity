<?php

namespace Modules\Companion\App\Http\Requests\HelpUser;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $helpUserId = Helpers::getModelIdOnPut('helpUser');

        return [
                'name' => ["required","string","max:200"],
                'national_code' => ["required","string","digits:10","unique:help_users,national_code," . $helpUserId],
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
