<?php

namespace Modules\Dashboard\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Partner\App\Models\PartnerGroup;

class DashboardController extends Controller
{
    public function index()
    {
        $partnerGroups = PartnerGroup::with([
                'city:id,name,province_id,user_id',
                'city.user:id,name',
                'province:id,name,user_id'
            ])
            ->where('status', PartnerGroup::STATUS_NEW)
            ->latest('id')
            ->take(15)
            ->get();

        return view('dashboard::admin.index', compact('partnerGroups'));
    }

}
