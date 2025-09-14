<?php

namespace Modules\Companion\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Equipment\App\Models\Equipment;

// use Modules\Companion\Database\Factories\HelpFactory;

class Help extends Model
{
    protected $fillable = ['companion_id','type'];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot('quantity');
    }
}
