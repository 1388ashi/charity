<?php

namespace Modules\Setting\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\Helpers\Helpers;
use Modules\Setting\App\Models\Setting;

class SettingStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|alpha_dash:ascii|max:191|unique:settings,name',
            'label' => 'required|string|max:191',
            'type' => ['required', 'string', Rule::in(array_keys(Setting::getAllTypes()))]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function passedValidation(): void
    {
        $groups = array_keys(Setting::getAllGroups());
        if (! in_array($this->route('group'), $groups)) {
            throw Helpers::makeWebValidationException('گروه وارد شده نامعتبر است!');
        }
    }

}
