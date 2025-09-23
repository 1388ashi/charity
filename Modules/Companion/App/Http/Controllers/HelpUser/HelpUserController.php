<?php

namespace Modules\Companion\App\Http\Controllers\HelpUser;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Companion\App\Http\Requests\Front\EquipmentHelpRequest;
use Modules\Companion\App\Http\Requests\HelpUser\UpdateRequest;
use Modules\Companion\App\Models\CompanionCode;
use Modules\Companion\App\Models\Help;
use Modules\Companion\App\Models\HelpUser;
use Modules\Equipment\App\Models\Equipment;
use Modules\Invoice\App\Models\Payment;

class HelpUserController extends Controller
{
    public function index()
    {
        $code = request('code');
        $user = auth('help_user')->user();
        $helps = Help::with('companion:id,name')->where('help_user_id',$user->id)->get();

        return view('companion::help-user.index',compact('code','user','helps'));
    }

    public function update(UpdateRequest $request,HelpUser $helpUser){
        $helpUser->update($request->validated());

        return redirect()->back()->with('success', 'اطلاعات شما با موفقیت بروزرسانی شد.');
    }

    public function helpPage()
    {
        $gateways = Payment::getAvailableDriversForFront();
        $code = request()->query('code');
        $companion = $code ? CompanionCode::where('code', $code)->first() : null;
        // throw_unless($companion,ModelNotFoundException::class);
        $equipments = Equipment::all();

        return view('companion::help-user.pay',compact('companion','equipments','code'));
    }
    public function pay(EquipmentHelpRequest $request)
    {
        $data = $request->validated();

        if ($request->help_type != 'cash' && filled($data['amount'])) {
            unset($data['amount']);
        }
        $help = Help::query()->create($data);

        if ($request->filled('equipments') && $request->help_type == 'objects') {
            $pivotData = collect($request->equipments)
                ->mapWithKeys(fn ($eq) => [
                    $eq['id'] => ['quantity' => $eq['quantity']]
                ])
                ->toArray();
            $help->equipments()->attach($pivotData);
            return redirect()->back()->with('success', 'همیاری شما با موفقیت ثبت شد ✅');
        }
        elseif($request->help_type == 'cash' && $request->amount){
            return $help->pay();
        }
        //TODO: maybe send sms to that person;
    }

}
