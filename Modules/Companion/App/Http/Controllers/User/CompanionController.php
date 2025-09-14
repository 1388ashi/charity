<?php

namespace Modules\Companion\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Area\App\Models\City;
use Modules\Companion\App\Http\Requests\User\StoreRequest;
use Modules\Companion\App\Http\Requests\User\UpdateRequest;
use Modules\Companion\App\Models\Companion;

class CompanionController extends Controller
{
    public function management()
    {
        $user = auth('user')->user()->load('cities');

        return view('companion::user.management',compact('user'));
    }
    public function index(City $city)
    {
        $companions = Companion::query()->where('city_id',$city->id)->get();

        return view('companion::user.index',compact('city','companions'));
    }

    public function store(StoreRequest $request) 
    {
        Companion::query()->create($request->validated());

        return redirect()->back()->with('success', 'همیار با موفقیت ثبت شد.');
    }

    public function update(UpdateRequest $request, Companion $companion) 
    {
        $companion->update($request->validated());

        return redirect()->back()->with('success', 'همیار با موفقیت بروزرسانی شد.');
    }

    public function destroy(Companion $companion) 
    {
        $companion->delete();

        return redirect()->back()->with('success', 'همیار با موفیت حذف شد.');
    }
}
