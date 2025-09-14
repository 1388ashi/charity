<?php

namespace Modules\Area\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Area\App\Http\Requests\Admin\City\StoreRequest;
use Modules\Area\App\Http\Requests\Admin\City\UpdateRequest;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\User\App\Models\User;

class CityController extends Controller
{
    public function management()
    {
        $cities = City::latest('id')->filters()->paginate();
        $provinces = Province::query()->with('cities')->select('id', 'name','user_id')->active()->get();

        return view('area::admin.city.city-management', compact('cities', 'provinces'));
    }
    public function index($province_id)
    {
        $cities = City::latest('id')->where('province_id',$province_id)->filters()->paginate();
        $province = Province::find($province_id);
        $users = User::query()->latest('id')->get();

        return view('area::admin.city.index', compact('cities','users', 'province'));
    }

    public function show(int $id)
    {
        $city = City::findOrFail($id);

        return response()->success('', compact('city'));
    }

    public function store(StoreRequest $request)
    {
        City::query()->create($request->validated());

        return redirect()->back()->with('success', 'شهر با موفقیت ثبت شد.');
    }


    public function update(UpdateRequest $request, int $id)
    {
        $city = City::query()->findOrFail($id);
        $city->update($request->validated());

        return redirect()->back()->with('success', 'شهر با موفقیت بروز شد.');
    }

    public function destroy(int $id)
    {
        $city = City::find($id);
        $city = City::destroy($id);

        return redirect()->back()->with('success', 'شهر با موفیت حذف شد.');
    }

    public function getByProvince($province_id)
    {
        $cities = City::where('province_id', $province_id)->get(['id','name']);
        
        return response()->json($cities);
    }
}
