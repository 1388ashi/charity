<?php

namespace Modules\Companion\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Companion\App\Http\Requests\Front\EquipmentHelpRequest;
use Modules\Companion\App\Models\CompanionCode;
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
        dd($request->all());
    }
}
