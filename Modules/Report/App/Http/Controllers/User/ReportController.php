<?php

namespace Modules\Report\App\Http\Controllers\User;

use Bavix\Wallet\Models\Transaction;
use Modules\Area\App\Models\City;
use Modules\Companion\App\Models\Companion;
use Modules\Companion\App\Models\Help;
use Modules\Report\App\Http\Controllers\BaseReportController;

class ReportController extends BaseReportController
{
    protected string $viewPrefix = 'user';
     private $user;

    public function __construct()
    {
        $this->user = auth('user')->user()->load('cities', 'provinces');
    }
    protected function filterCitiesQuery($query)
    {
        return $query->where('user_id', auth('user')->id());
    }
     public function partnerManagement()
    {
        return view('report::user.partners-detail', [
            'user' => $this->user
        ]);
    }

    public function companionTransaction()
    {
        $companions = Companion::latest('id')->get();
        $transactions = Transaction::query()
            ->whereHasMorph('payable', [Companion::class], function ($q) {
                if (request('companion_id')) {
                    $q->where('id', request('companion_id'));
                }
            })
            ->when(request('start_date'), function ($q) {
                $q->whereDate('created_at', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('created_at', '<=', request('end_date'));
            })
            ->latest()
            ->paginate(20);

        return view('report::user.companion-transactions', compact('transactions','companions'));
    }
    
    public function companionManagement()
    {
        return view('report::user.companion-management', [
            'user' => $this->user
        ]);
    }

    public function companionFilterByCity(City $city)
    {
        $companions = Companion::query()->where('city_id',$city->id)->get();
        $helps = Help::with('helpUser:id,name,mobile','companion:id,name,mobile','equipments:id,name')
            ->reportFilters()
            ->latest()
            ->get();

        return view('report::user.companion-city-list',compact('helps','companions','city'));
    }
}
