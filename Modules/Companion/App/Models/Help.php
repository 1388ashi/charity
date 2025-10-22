<?php

namespace Modules\Companion\App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Companion\App\Models\HelpUser;
use Modules\Core\Classes\CoreSettings;
use Modules\Sms\Sms;
use Modules\Equipment\App\Models\Equipment;
use Modules\Invoice\Classes\Payable;

class Help extends Payable
{
    protected $fillable = ['companion_id','help_user_id','type','status_payment','amount'];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot('quantity');
    }
    public function helpUser()
    {
        return $this->belongsTo(HelpUser::class,'help_user_id');
    }
    public function companion()
    {
        return $this->belongsTo(Companion::class);
    }
    public function isPayable()
    {
        return $this->status == 0;
    }

    public function getPayableAmount()
    {
        return $this->amount;
    }
   public static function getHelpData($user = null)
    {
        $cityIds = $user?->cities?->pluck('id')->toArray();

        $helps = Help::with([
                'helpUser:id,name,mobile',
                'companion:id,name,city_id',
                'companion.city:id,name',
                'equipments:id,name'
            ])
            ->when($cityIds, function ($query) use ($cityIds) {
                $query->whereHas('companion', function ($q) use ($cityIds) {
                    $q->whereIn('city_id', $cityIds);
                });
            })
            ->latest()
            ->take(10)
            ->get();

        $todayTotal = Help::where('type', 'cash')
            ->whereDate('created_at', Carbon::today())
            ->when($cityIds, function ($query) use ($cityIds) {
                $query->whereHas('companion', function ($q) use ($cityIds) {
                    $q->whereIn('city_id', $cityIds);
                });
            })
            ->sum('amount');

        $weekTotal = Help::where('type', 'cash')
            ->whereBetween('created_at', [
                Carbon::now()->subWeek()->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->when($cityIds, function ($query) use ($cityIds) {
                $query->whereHas('companion', function ($q) use ($cityIds) {
                    $q->whereIn('city_id', $cityIds);
                });
            })
            ->sum('amount');

        $monthTotal = Help::where('type', 'cash')
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->when($cityIds, function ($query) use ($cityIds) {
                $query->whereHas('companion', function ($q) use ($cityIds) {
                    $q->whereIn('city_id', $cityIds);
                });
            })
            ->sum('amount');

        $allTotal = Help::where('type', 'cash')
            ->when($cityIds, function ($query) use ($cityIds) {
                $query->whereHas('companion', function ($q) use ($cityIds) {
                    $q->whereIn('city_id', $cityIds);
                });
            })
            ->sum('amount');

        return [
            'helps'      => $helps,
            'todayTotal' => $todayTotal,
            'weekTotal'  => $weekTotal,
            'monthTotal' => $monthTotal,
            'allTotal'   => $allTotal,
        ];
    }

    public function scopeFilters($q){
        $name = request('name');
        $start_date = request('start_date');
        $end_date = request('end_date');

        return $q        
            ->when($name, function ($q) use($name) {
                $q->whereHas('helpUser',function ($q) use ($name) {
                        $q->where('name', 'like', '%' . $name . '%');
                    });
            })
            ->when($start_date, function ($q)use($start_date) {
                $q->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($q) use($end_date) {
                $q->whereDate('created_at', '<=', $end_date);
            });
    }
    public function scopeReportUserFilters($q){
        $companion_id = request('companion_id');
        $start_date = request('start_date');
        $end_date = request('end_date');

        return $q        
            ->when($companion_id, function ($q) use($companion_id) {
                $q->whereHas('companion',function ($q) use ($companion_id) {
                        $q->where('companion_id',$companion_id);
                    });
            })
            ->when($start_date, function ($q)use($start_date) {
                $q->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($q) use($end_date) {
                $q->whereDate('created_at', '<=', $end_date);
            });
    }
    public function scopeReportAdminFilters($q){
        $companion_id = request('companion_id');
        $city_id = request('city_id');
        $start_date = request('start_date');
        $end_date = request('end_date');

        return $q        
            ->when($companion_id, function ($q) use($companion_id) {
                $q->whereHas('companion',function ($q) use ($companion_id) {
                        $q->where('companion_id',$companion_id);
                    });
            })
            ->when($city_id, function ($q) use ($city_id) {
                $q->whereHas('companion.city', function ($q) use ($city_id) {
                    $q->where('id', $city_id);
                });
            })
            ->when($start_date, function ($q)use($start_date) {
                $q->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($q) use($end_date) {
                $q->whereDate('created_at', '<=', $end_date);
            });
    }
     public function callBackViewPayment($invoice): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('core::invoice.callback',
            [
                'invoice' => $invoice,
                'type' => 'order'
            ]
        );
    }


    
    public function onSuccessPayment(\Modules\Invoice\App\Models\Invoice $invoice)
    {
         $this->update([
            'status_payment' => 1,
        ]);
        if ($this->companion_id && $this->companion->salary_type == 'percentage') {
            $percentage = $this->companion->salary ?? 10;
            $return = $this->amount / 100 * $percentage;
            $this->companion->deposit($return, [
               'causer_id' => $this->helpUser->id,
               'causer_mobile' => $this->helpUser->mobile,
               'description' => "درصد بابت کمک با شناسه" . $this->id,
           ]);
        }
        $pattern = app(CoreSettings::class)->get('sms.patterns.new_help_user');
        $output = Sms::pattern($pattern)  
        ->data([  
            'token' => '.',
        ])->to([$this->helpUser->mobile])->send();  
        if ($output['status'] != 200){
            Log::debug('', [$output]);
        }
        return $this->callBackViewPayment($invoice);
    }
}
