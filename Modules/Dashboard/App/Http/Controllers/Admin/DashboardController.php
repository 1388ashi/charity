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
            ->paginate(20);

        return view('dashboard::admin.index', compact('partnerGroups'));
    }

}
