<?php

namespace Modules\Companion\App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Admin\App\Models\Admin;
use Modules\Companion\App\Http\Requests\Withdraw\StoreRequest;
use Modules\Core\Classes\CoreSettings;
use Modules\User\App\Models\Withdraw;

class WithdrawController extends Controller
{
     public function wallet()
    {
        $companion = auth('companion')->user();
        // $bankAccounts = $companion->bankAccounts;
        $withdraws = Withdraw::latest()
        ->where('companion_id', $companion->id)->paginate();

        return view('companion::companion.wallet.index', compact('withdraws','companion'));
    }
      public function index()
    {
        $companion = auth('companion')->user();
        // $bankAccounts = $companion->bankAccounts;
        $withdraws = Withdraw::latest()
        ->where('companion_id', $companion->id)->paginate();

        return view('companion::companion.wallet.index', compact('withdraws','companion'));
    }

    // public function show(Withdraw $withdraw)
    // {
    //     $companion = auth('companion')->user();
    //     $withdraw->where('companion_id', $companion->id)->loadCommonRelations();

    //     return response()->success('', compact('withdraw'));
    // }

    public function cancel($id)
    {
        $companion = auth('companion')->user();
        $withdraw = Withdraw::where('companion_id', $companion->id)->findOrFail($id);

        try {
            DB::beginTransaction();
            $withdraw->status = Withdraw::STATUS_CANCELED;
            $withdraw->save();
            $withdraw->loadCommonRelations();
            DB::commit();
            $withdraws = $this->index()->original['data']['withdraws'];

        } catch (\Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getTraceAsString());

            return response()->error('مشکلی رخ داد. ', $throwable->getTrace());
        }

        return redirect()->back()->with('success', 'با موفقیت لغو شد.');
    }

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $withdraw = Withdraw::store(auth('companion')->user(), $request);
            $admin = Admin::where('id',1)->first();
            // $pattern = app(CoreSettings::class)->get('sms.patterns.request_booth_wallet');
            // $output = Sms::pattern($pattern)  
            // ->data([  
            //     'token' => '.',
            // ])->to([$admin->mobile])->send();  
            // if ($output['status'] != 200){
            //     Log::debug('', [$output]);
            // }
            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getTraceAsString());
            return redirect()->back()->with('error', 'مشکل در درخواست برداشت.'. $throwable->getMessage());

        }
        return redirect()->back()->with('success', 'درخواست برداشت از حساب با موفقیت انجام شد.');
    }
}