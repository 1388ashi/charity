<?php

namespace Modules\Area\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booth\App\Models\Booth;
use Modules\Companion\Models\Companion;
use Modules\Partner\App\Models\PartnerGroup;
use Modules\User\App\Models\User;

// use Modules\Area\Database\Factories\CityFactory;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'province_id', 'status','user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['province'];


    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function partnerGroups()
    {
        return $this->hasMany(PartnerGroup::class);
    }
    public function companions()
    {
        return $this->hasMany(Companion::class);
    }
    public function scopeActive($query)
    {
        $query->where('status', true);
    }

    public function isDeletable(): bool
    {
        return true;
    }
    public static function citiesUserGroup(){
        
    }
    public function scopeFilters($query)
    {
        return $query
        ->when(request('id'), fn($q) => $q->where('id', request('id')))
        ->when(!is_null(request('status')), fn($q) => $q->where('status', request('status')))
        ->when(request('province_id'), function($q) {
            if (request('province_id') != 'all') {
            $q->where('province_id', request('province_id'));
            }
        })
        ->when(request('name'), fn($q) => $q->where('name', 'LIKE', '%' . request('name') . '%'))
        ->when(request('start_date'), fn($q) => $q->whereDate('created_at', '>=', request('start_date')))
        ->when(request('end_date'), fn($q) => $q->whereDate('created_at', '<=', request('end_date')));
    }
}
