<?php

namespace Modules\Core\Rules;

use Shetabit\Shopit\Modules\Core\Rules\Base64Image;
use Shetabit\Shopit\Modules\Core\Rules\Base64OrMediaId as BaseBase64OrMediaId;


use Illuminate\Contracts\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Base64OrMediaId implements Rule
{
    protected $mime;

    public function __construct($mime = 'gif|png|jpg|jpeg|svg|webp')
    {
        $this->mime = $mime;
    }

    public function passes($attribute, $value): bool
    {
        $base64Rule = new Base64Image($this->mime);
        if ($base64Rule->passes($attribute, $value)) {
            return true;
        }
        $media = Media::find($value);

        return \File::isFile($value) || (bool) $media;
    }


    public function message(): string
    {
        return ' عکس انتخاب شده یافت نشده: ' . ':input';
    }
}
