<?php

namespace Modules\Companion\App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentHelpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //general
            'name' => 'required|string',
            'national_code' => 'required|string|digits:10|unique:helps,national_code',
            'mobile' => 'required|string|digits:11|unique:helps,mobile',

            //equipments
            'equipments'              => ['nullable', 'array'],
            'equipments.*.id'        => ['nullable','integer','exists:equipments,id'],
            'equipments.*.quantity'        => ['nullable','integer'],
        ];
    }
    
    public function authorize(): bool
    {
        return true;
    }
}
