<?php

namespace Modules\Auth\App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\IranMobile;
use Illuminate\Validation\ValidationException;
use Modules\User\App\Models\SmsToken;

class UserLoginRequest extends FormRequest
{
 public function rules(): array
    {
        return [
            'mobile' => ['required', 'digits:11', new IranMobile()],
            'sms_token' => 'required',
        ];
    }

    public function passedValidation()
    {
        $smsToken = SmsToken::where('mobile', $this->mobile)->first();
        
        if (!$smsToken) {
            throw ValidationException::withMessages([
                'mobile' => ['کاربری با این مشخصات پیدا نشد!']
            ]);
        } elseif ($smsToken->token !== $this->sms_token) {
            throw ValidationException::withMessages([
                'sms_token' => ['کد وارد شده نادرست است!']
            ]);
        } 
        elseif (Carbon::now()->gt($smsToken->expired_at)) {
            throw ValidationException::withMessages([
                'sms_token' => ['کد وارد شده منقضی شده است!']
            ]);
        }

        $this->merge([
            'smsToken' => $smsToken,
        ]);
    }
    public function authorize(): bool
    {
        return true;
    }
}
