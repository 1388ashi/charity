<?php

namespace Modules\Companion\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Companion\App\Http\Requests\User\ChangeAmountRequest;
use Modules\Companion\App\Models\Companion;
use Modules\User\App\Models\Withdraw;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::with('companion:id,name,mobile')->userFilters()->latest()->paginate();
        $companions = Companion::latest('id')->get();
        
        return view('companion::user.withdraw.index', compact('withdraws','companions'));
    }

    public function editStatus(Withdraw $withdraw, Request $request)
    {
        $withdraw->update(['status' => $request->status]);
        if ($request->status == 'approved') {
            $companion = $withdraw->companion;

            $companion->withdraw($withdraw->amount, [
                'description' => 'برداشت توسط کارشناس',
                'withdraw_id' => $withdraw->id,
            ]);
        }
        return redirect()->back()->with('success', 'وضعیت با موفقیت به روزرسانی شد.');
    }

    public function changeBalanceWallet(ChangeAmountRequest $request) {
        $companion = Companion::find($request->companion_id);
        $userId = auth('user')->id(); 

        if ($request->type == 'addition') {
            $companion->deposit($request->amount, [
                'description' => "افزایش کیف پول توسط کارشناس با کد {$userId}",
            ]);
        } else {
            $companion->withdraw($request->amount, [
                'description' => "برداشت کیف پول توسط کارشناس با کد {$userId}",
            ]);
        }

        return redirect()->back()->with('success', 'کیف پول با موفقیت به روزرسانی شد.');

    }
}
