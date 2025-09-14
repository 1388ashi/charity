<?php

namespace Modules\Report\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\Partner\App\Models\PartnerGroup;
use Modules\Report\App\Http\Controllers\BaseReportController;

class ReportController extends BaseReportController
{
    protected string $viewPrefix = 'admin';
    public function partnersDetail(){
        $provinces = Province::query()->with('cities')->select('id', 'name')->active()->get();
        $allStatuses = PartnerGroup::$statuses;

        $provincesReport = $this->withPartnerGroupStatuses(
            Province::query()
                ->when(request('province_id'), fn($q) => $q->where('id', request('province_id')))
                ->with('user:id,name')
        )->get();
        $totals = [
            'new' => $provincesReport->sum('new_count'),
            'pending' => $provincesReport->sum('pending_count'),
            'await_payment' => $provincesReport->sum('await_payment_count'),
            'paid' => $provincesReport->sum('paid_count'),
            'rejected' => $provincesReport->sum('rejected_count'),
        ];

        return view('report::admin.partners-detail',compact('provincesReport','provinces','allStatuses','totals'));
    }
}
