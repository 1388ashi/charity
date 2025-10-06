<?php

namespace Modules\Companion\App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Companion\App\Models\Companion;
use Modules\Core\Helpers\Helpers;

class ChangeAmountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|in:addition,reduction',
            'amount' => 'required|integer',
            'companion_id' => 'required|integer|exists:companions,id',
        ];
    }

     public function passedValidation()
    {
        $this->checkBalance();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => intval(str_replace(',', '', $this->input('amount'))),
        ]);
    }

    public function checkBalance()
    {
        if ($this->type == 'reduction') {
            $companion = Companion::find($this->companion_id);
            
            if ($companion->wallet->balance < $this->amount) {
                throw Helpers::makeValidationException('مبلغ مورد نظر از شارژ کیف پول بیشتر است');
            }
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
