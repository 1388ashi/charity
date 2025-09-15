<?php

namespace Modules\Companion\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Companion\App\Http\Requests\Front\EquipmentHelpRequest;
use Modules\Companion\App\Models\CompanionCode;
use Modules\Companion\App\Models\Help;
use Modules\Equipment\App\Models\Equipment;

class CompanionController extends Controller
{
    public function helpPage()
    {
        $code = request()->query('code');
        $companion = CompanionCode::where('code', $code)->first();
        throw_unless($companion,ModelNotFoundException::class);
        $equipments = Equipment::all();

        return view('companion::front.pay',compact('companion','equipments'));
    }
    public function pay(EquipmentHelpRequest $request)
    {
        $help = Help::query()->create($request->validated());

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
            dd(1);
            //TODO: if payment is success,update column status_payment to true;
        }
        //TODO: maybe send sms to that person;
    }
}
