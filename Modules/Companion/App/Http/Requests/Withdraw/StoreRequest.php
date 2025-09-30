<?php

namespace Modules\Companion\App\Http\Requests\Withdraw;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Helpers\Helpers;

class StoreRequest extends FormRequest
{
     public function rules()
    {
        return [
            'amount' => 'required|integer|min:1000',
            // 'bank_account_id' => 'required|integer',
        ];
    }

    public function passedValidation()
    {
        $this->checkBalance();
    }


    public function checkBalance()
    {
        $companion = auth('companion')->user();
        if ($companion->wallet->balance < $this->amount) {
            throw Helpers::makeValidationException('مبلغ مورد نظر از شارژ کیف پول بیشتر است');
        }
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => intval(str_replace(',', '', $this->input('amount'))),
        ]);
    }
    // public function all($keys = null)
    // {
    //     $companion = auth('companion')->user();
    //     $all = parent::all($keys);
        
    //     $excepts = ['tracking_code'];
        
    //     foreach ($excepts as $except) {
    //         unset($all[$except]);
    //     }
        
    //     $fields = [
    //         'bank_account_number' => $companion->bank_account_number,
    //         'card_number' => $companion->card_number,
    //         'shaba_code' => $companion->shaba_code
    //     ];
        
    //     return array_merge($all, $fields);
    // }
}
