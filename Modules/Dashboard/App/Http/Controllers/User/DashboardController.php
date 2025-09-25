<?php

namespace Modules\Dashboard\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Modules\Companion\App\Models\Help;
use Modules\Partner\App\Models\PartnerGroup;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth('user')->user()->id;
        $partnerGroups = PartnerGroup::with([
                'city:id,name,province_id,user_id',
                'city.user:id,name',
                'province:id,name,user_id'
            ])
            ->where('status', PartnerGroup::STATUS_NEW)
            ->where(function ($q) use ($userId) {
                $q->whereHas('city', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->orWhereHas('province', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            })
            ->latest('id')
            ->get();
        extract(Help::getHelpData());

        return view('dashboard::user.index', compact('partnerGroups','helps','todayTotal','weekTotal','monthTotal','allTotal'));
    }
}
