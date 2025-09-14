<?php

namespace Modules\Partner\App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //group
            'marriage_date'          => ['required', 'date'],
            'marriage_location'      => ['nullable', 'string', 'max:255'],
            'marriage_certificate_no'=> ['nullable', 'string', 'max:50'],
            'notes'                  => ['nullable', 'string'],
            'city_id'                => ['required','integer','exists:cities,id'],
            'province_id'            => ['required','integer','exists:provinces,id'],
            
            //patners
            'partners'               => ['required', 'array', 'size:2'], 
            'partners.*.gender'      => ['required', 'in:male,female'],
            'partners.*.name'        => ['required', 'string', 'max:100'],
            'partners.*.birth_date'  => ['required', 'date'],
            'partners.*.national_code' => ['required','string','max:20','unique:partners,national_code'],
            'partners.*.phone'       => ['required', 'string', 'max:20'],
            'partners.*.address'     => ['required', 'string'],
            'partners.*.job'         => ['required', 'string', 'max:100'],
            'partners.*.education'   => ['required', 'string', 'max:100'],
            
            //equipments
            'equipments'              => ['nullable', 'array'],
            'equipments.*'            => ['integer', 'exists:equipments,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
