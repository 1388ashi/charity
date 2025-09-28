<?php

namespace Modules\Dashboard\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Modules\Companion\App\Models\Help;
use Modules\Partner\App\Models\PartnerGroup;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth('user')->user();
        $user->load('city');
        $partnerGroups = PartnerGroup::with([
                'city:id,name,province_id,user_id',
                'city.user:id,name',
                'province:id,name,user_id'
            ])
            ->where('status', PartnerGroup::STATUS_NEW)
            ->where(function ($q) use ($user) {
                $q->whereHas('city', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orWhereHas('province', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->latest('id')
            ->get();
        extract(Help::getHelpData($user));

        return view('dashboard::user.index', compact('partnerGroups','helps','todayTotal','weekTotal','monthTotal','allTotal'));
    }
}
