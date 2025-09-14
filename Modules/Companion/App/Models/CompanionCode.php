<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Companion\Database\Factories\CompanionCodeFactory;

class CompanionCode extends Model
{

    protected $fillable = ['companion_id','code'];

    public function companion()
    {
        return $this->belongsTo(Companion::class);
    }
}
