<?php

namespace Modules\Companion\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\App\Models\Withdraw;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::with('exhibitor:id,name,mobile')->latest()->paginate();

        return view('companion::user.withdraw.index', compact('withdraws'));
    }

    public function show(Withdraw $withdraw)
    {
        $withdraw->loadCommonRelations();

        return response()->success('', compact('withdraw'));
    }

    public function editStatus(Withdraw $withdraw, Request $request)
    {
        $withdraw->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'وضعیت با موفقیت به روزرسانی شد.');
    }
}
