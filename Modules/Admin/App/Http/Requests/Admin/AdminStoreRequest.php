<?php

namespace Modules\Admin\App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\Rules\IranMobile;

class AdminStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'mobile' => ['required', new IranMobile(), Rule::unique('admins')],
            'password' => 'required|string|max:50|confirmed',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->has('status')
        ]);
    }

    protected function passedValidation()
    {
        $this->merge([
            'password' => bcrypt($this->input('password'))
        ]);
    }
}
