<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Modules\Area\App\Models\City;

class Companion extends Authenticatable
{
    protected $fillable = ['name','national_code','mobile','city_id','salary_type','salary'];
    
    public function isDeletable(): bool
    {
        return true;
    }
    protected static function booted()
    {
        static::created(function ($companion) {
            CompanionCode::create([
                'companion_id' => $companion->id,
                'code' => Str::random(10),
            ]);
            //TODO: send code to companion| generate url and code
        });
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function tokenCode()
    {
        return $this->hasOne(CompanionCode::class);
    }
}
