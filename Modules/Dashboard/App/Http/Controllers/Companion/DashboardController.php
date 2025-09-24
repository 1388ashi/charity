<?php

namespace Modules\Dashboard\App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Companion\App\Models\Help;

class DashboardController extends Controller
{
    public function index()
    {
        $companionId = auth('companion')->user()->id;
        $helps = Help::with('helpUser:id,name,mobile','equipments:id,name')->latest()->take(10)->where('companion_id',$companionId)->get();

        return view('dashboard::companion.index', compact('helps'));
    }

}
