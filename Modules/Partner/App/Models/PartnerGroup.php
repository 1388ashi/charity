<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\Equipment\App\Models\Equipment;
// use Modules\Partner\Database\Factories\PartnerGroupFactory;

class PartnerGroup extends Model
{
    use HasFactory;

    protected $fillable = ['marriage_date', 'marriage_location', 'marriage_certificate_no','status', 'notes','status_description','province_id','city_id'];

    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_AWAIT_PAYMENT = 'await_payment';
    const STATUS_PAID = 'paid';
    const STATUS_REJECTED = 'rejected';
    public static $statuses = [
        self::STATUS_NEW => 'جدید',
        self::STATUS_PENDING => 'در حال بررسی',
        self::STATUS_AWAIT_PAYMENT => 'در انتظار پرداخت',
        self::STATUS_PAID => 'پرداخت شده',
        self::STATUS_REJECTED => 'رد شده',
    ];

    public function scopeAdminFilters($query)
    {
        $status = request('status');
        
        return $query
            ->when(request('province_id'), function ($q) {
                    $q->whereRelation('province','id', request('province_id'));
            })
            ->when(request('city_id'), function ($q) {
                    $q->whereRelation('city','id', request('city_id'));
            })
            ->when(request('start_date'), function ($q) {
                $q->whereDate('created_at', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('created_at', '<=', request('end_date'));
            })
            ->when(isset($status), fn($query) => $query->where("status", $status));
    }
    public function scopeProvinceFilters($query)
    {
        $status = request('status');
        
        return $query
            ->when(request('city_id'), function ($q) {
                    $q->whereRelation('city','id', request('city_id'));
            })
            ->when(request('start_date'), function ($q) {
                $q->whereDate('created_at', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('created_at', '<=', request('end_date'));
            })
            ->when(isset($status), fn($query) => $query->where("status", $status));
    }
    public function scopeCityFilters($query)
    {
        $status = request('status');

        return $query
            ->when(request('start_date'), function ($q) {
                $q->whereDate('created_at', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('created_at', '<=', request('end_date'));
            })
            ->when(isset($status), fn($query) => $query->where("status", $status));
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_partner_group')
                ->withPivot(['is_provided']);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function partners()
    {
        return $this->hasMany(Partner::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
