<?php

namespace Modules\Companion\App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Companion\App\Models\Help;
use Modules\Core\Classes\Transaction;

class CompanionController extends Controller
{
    public function index()
    {
        $companionId = auth('companion')->user()->id;
        $helps = Help::with('helpUser:id,name,mobile', 'equipments:id,name')
            ->filters()
            ->latest()
            ->where('companion_id', $companionId)
            ->paginate(10)
            ->withQueryString();

        return view('companion::companion.index', compact('helps'));
    }
    public function transactions()
    {
        $companion = auth('companion')->user();

        $transactions = $companion->transactions()->paginate(10);

        return view('companion::companion.report.transactions', compact('transactions'));
    }
}
