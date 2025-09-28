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
            'salary_type' => 'required|in:percentage,fixed',
            'salary' => 'required|min:0'
        ];
    }

     protected function prepareForValidation()
    {
        $this->merge([
            'salary' => str_replace(',', '', $this->input('salary')),
        ]);
    }
    public function authorize(): bool
    {
        return true;
    }
}
