<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Equipment\App\Models\Equipment;

// use Modules\Companion\Database\Factories\HelpFactory;

class Help extends Model
{
    protected $fillable = ['name','companion_id','type','national_code','status_payment','mobile'];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot('quantity');
    }
}
