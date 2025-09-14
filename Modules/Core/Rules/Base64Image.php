<?php

namespace Modules\Core\Rules;

//use Shetabit\Shopit\Modules\Core\Rules\Base64Image as BaseBase64Image;


use Illuminate\Contracts\Validation\Rule;
use Modules\Core\Helpers\Helpers;

class Base64Image implements Rule
{
    protected string $mime = '';

    public function __construct(string $mime = 'gif|png|jpg|jpeg')
    {
        $this->mime = $mime;
    }

    public function passes($attribute, $value): bool
    {
        return Helpers::isStringBase64($value, $this->mime);
    }

    public function message(): string
    {
        return trans('validation.base64Image');
    }
}
