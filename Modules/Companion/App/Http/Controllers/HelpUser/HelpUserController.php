<?php

namespace Modules\Companion\App\Http\Controllers\HelpUser;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Companion\App\Http\Requests\HelpUser\EquipmentHelpRequest;
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
        $helps = Help::with('companion:id,name,mobile','equipments:id,name')->latest()->where('help_user_id',$user->id)->get();
        $totalAmountHelp = Help::where('help_user_id', $user->id)
            ->where('type', 'cash')
            ->sum('amount');
        $totalEquipmentHelp = Help::join('equipment_help', 'helps.id', '=', 'equipment_help.help_id')
            ->sum('equipment_help.quantity');
        
            return view('companion::help-user.index',compact('code','user','helps','totalAmountHelp','totalEquipmentHelp'));
    }
    
    public function profile() {
        $code = request('code');
        $user = auth('help_user')->user();
        
        return view('companion::help-user.profile',compact('code','user'));
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
        $data['help_user_id'] = auth('help_user')->user()->id;
        if ($request->type != 'cash' && filled($data['amount'])) {
            unset($data['amount']);
        }
        $help = Help::query()->create($data);
        
        if ($request->filled('equipments') && $request->type == 'objects') {
            $pivotData = collect($request->equipments)
                ->mapWithKeys(fn ($eq) => [
                    $eq['id'] => ['quantity' => $eq['quantity']]
                ])
                ->toArray();
            $help->equipments()->attach($pivotData);
            //go to list
            return redirect()->to('/help-user/list?code=' . urlencode($request->code ?? ''))->with('success', 'همیاری شما با موفقیت ثبت شد ✅');
        }
        elseif($request->type == 'cash' && $request->amount){
            return $help->pay();
        }
        //TODO: maybe send sms to that person;
    }

}
