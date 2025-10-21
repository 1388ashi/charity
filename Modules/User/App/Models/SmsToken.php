<?php

namespace Modules\User\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'mobile', 'token', 'expired_at', 'verified_at'
    ];

    protected $dates = [
        'expired_at', 'verified_at'
    ];
}
