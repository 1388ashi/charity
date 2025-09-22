<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Companion\App\Models\Help;

// use Modules\Companion\Database\Factories\HelpUserFactory;

class helpUser extends Model
{
    protected $table = 'help_users';
    protected $fillable = [
        'mobile','name','national_code','code'
    ];

    public function helps(){
        return $this->hasMany(Help::class,'help_user_id');
    }
}
