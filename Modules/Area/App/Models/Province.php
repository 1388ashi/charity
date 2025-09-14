<?php

namespace Modules\Area\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Partner\App\Models\PartnerGroup;
use Modules\User\App\Models\User;

// use Modules\Area\Database\Factories\ProvinceFactory;

class Province extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status','user_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }
    public function partnerGroups()
    {
        return $this->hasMany(PartnerGroup::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function scopeActive($query)
    {
        $query->where('status', true);
    }

    public function isDeletable(): bool
    {
        return $this->cities->isEmpty();
    }

    public function scopeFilters($query)
    {
        return $query
        ->when(request('id'), fn($q) => $q->where('id', request('id')))
        ->when(request('name'), fn($q) => $q->where('name', 'LIKE', '%'.request('name').'%'))
        ->when(request('start_date'), fn($q) => $q->whereDate('created_at', '>=', request('start_date')))
        ->when(request('end_date'), fn($q) => $q->whereDate('created_at', '<=', request('end_date')));
    }
    public function storeUserToAllCities($request)
    {
        if ($request->all_cities) {
            $cities = City::where('province_id',$this->id)->get();
            foreach ($cities as $city) {
                $city->update(['user_id' => $request->user_id]);
            }
        }
    }
}
