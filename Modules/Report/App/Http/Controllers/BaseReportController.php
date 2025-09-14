<?php

namespace Modules\Report\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\Partner\App\Models\PartnerGroup;

abstract class BaseReportController extends Controller
{
    protected string $viewPrefix; 

    protected function withPartnerGroupStatuses($query)
    {
        return $query->withCount([
            'partnerGroups as new_count' => fn($q) => $q->where('status', 'new'),
            'partnerGroups as await_payment_count' => fn($q) => $q->where('status', 'await_payment'),
            'partnerGroups as pending_count' => fn($q) => $q->where('status', 'pending'),
            'partnerGroups as paid_count' => fn($q) => $q->where('status', 'paid'),
            'partnerGroups as rejected_count' => fn($q) => $q->where('status', 'rejected'),
        ]);
    }

    protected function filterCitiesQuery($query)
    {
        return $query;
    }

    public function partnersDetailCity(Province $province)
    {
        $allStatuses = PartnerGroup::$statuses;
        $citiesReport = $this->withPartnerGroupStatuses(
                City::where('province_id', $province->id)->with('user:id,name')
        )->get();

        $citiesUserGroup = City::where('province_id', $province->id)
            ->with(['user:id,name'])
            ->get()
            ->groupBy(fn($city) => $city->user->name ?? 'بدون کارشناس');

        $totals = [
            'new'           => $citiesReport->sum('new_count'),
            'pending'       => $citiesReport->sum('pending_count'),
            'await_payment' => $citiesReport->sum('await_payment_count'),
            'paid'          => $citiesReport->sum('paid_count'),
            'rejected'      => $citiesReport->sum('rejected_count'),
        ];

        return view("report::{$this->viewPrefix}.partners-detail-city", compact(
            'citiesReport', 'allStatuses', 'totals', 'province', 'citiesUserGroup'
        ));
    }

    public function partnersDetailList(City $city)
    {
        $allStatuses = PartnerGroup::$statuses;

        $basePartnersList = PartnerGroup::where('city_id', $city->id)
            ->when(request('start_date'), function ($q) {
                $q->whereDate('created_at', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('created_at', '<=', request('end_date'));
            })
            ->with('partners:id,partner_group_id,name,phone,national_code','city:id,name,user_id','city.user:id,name');
        $partnersListStatus = $basePartnersList->get();
        $partnersList = $basePartnersList->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->latest('id')->get();

        return view("report::{$this->viewPrefix}.partners-detail-list", compact(
            'city','partnersListStatus', 'partnersList', 'allStatuses'
        ));
    }
}