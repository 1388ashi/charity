<?php

namespace Modules\User\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Partner\App\Models\Note;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name','mobile','code','national_code','status'];
    protected $appends = [
        'balance',
    ];

    public function getBalanceAttribute()
    {
        return 0;
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public function scopeFilters($query)
    {
        return $query
        ->when(request('mobile'), fn($q) => $q->where('mobile', request('mobile')))
        ->when(request('national_code'), fn($q) => $q->where('national_code', request('national_code')))
        ->when(request('name'), fn($q) => $q->where('name', 'LIKE', '%' . request('name') . '%'));
    }
}
