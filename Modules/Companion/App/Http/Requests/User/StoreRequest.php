<?php

namespace Modules\Companion\App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'national_code' => 'required|string|digits:10|unique:companions,national_code',
            'mobile' => 'required|string|digits:11|unique:companions,mobile',
            'city_id' => 'required|integer|exists:cities,id',
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
