<?php

namespace Modules\Dashboard\App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Companion\App\Models\Help;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $companionId = auth('companion')->user()->id;
        $helps = Help::with('helpUser:id,name,mobile','equipments:id,name')->latest()->take(10)->where('companion_id',$companionId)->get();
        
        $todayTotal = Help::where('companion_id', $companionId)
            ->where('type', 'cash')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $weekTotal = Help::where('companion_id', $companionId)
            ->where('type', 'cash')
            ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfDay()])
            ->sum('amount');

        $monthTotal = Help::where('companion_id', $companionId)
            ->where('type', 'cash')
            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->endOfDay()])
            ->sum('amount');
        
        $allTotal = Help::where('companion_id', $companionId)
            ->where('type', 'cash')
            ->sum('amount');

        return view('dashboard::companion.index', compact('helps','todayTotal','weekTotal','monthTotal','allTotal'));
    }

}
