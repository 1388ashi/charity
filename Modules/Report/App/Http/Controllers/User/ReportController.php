<?php

namespace Modules\Report\App\Http\Controllers\User;

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
