<?php

namespace Modules\Equipment\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Companion\App\Models\Help;
use Modules\Partner\App\Models\PartnerGroup;
// use Modules\Equipment\Database\Factories\EquipmentFactory;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];
    protected $table = 'equipments';

    public function isDeletable(): bool
    {
        return $this->coupleGroups->isEmpty();
    }
    public function helps()
    {
        return $this->belongsToMany(Help::class)->withPivot('quantity');
    }
    public function coupleGroups()
    {
        return $this->belongsToMany(PartnerGroup::class, 'equipment_partner_group')
                ->withPivot(['is_provided']);
    }
}
