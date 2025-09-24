<?php

namespace Modules\Companion\App\Http\Requests\HelpUser;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentHelpRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            //general
            'type' => 'required|in:cash,objects',
            'companion_id' => 'nullable|integer|exists:companions,id',
            'amount' => 'nullable|integer|min:1000000',

            //equipments
            'equipments' => 'nullable|array',
            'equipments.*.id' => 'nullable|integer|exists:equipments,id',
            'equipments.*.quantity' => 'nullable|integer',
        ];
    }
    
    public function authorize(): bool
    {
        return true;
    }
}
