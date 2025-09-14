<?php

namespace Modules\Area\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Area\App\Http\Requests\Admin\Province\StoreRequest;
use Modules\Area\App\Http\Requests\Admin\Province\UpdateRequest;
use Modules\Area\App\Models\Province;
use Modules\User\App\Models\User;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::query()->filters()->latest('id')->paginate();
        $users = User::query()->latest('id')->get();

        return view('area::admin.province.index', compact('provinces','users'));
    }

    public function show(int $id)
    {
        $province = Province::with('cities')->findOrFail($id);

        if (request()->header('Accept') == 'application/json') {
        return response()->success('', compact('province'));
        }

        return view('area::admin.province.show', compact('province'));
    }

    public function store(StoreRequest $request)
    {
        $province = Province::query()->create($request->validated());
        $province->storeUserToAllCities($request);
        // ActivityLogHelper::simple('استان ثبت شد', 'store', $province);

        if (request()->header('Accept') == 'application/json') {
        return response()->success('استان با موفقیت ایجاد شد', compact('province'));
        }

        return redirect()->back()->with('success', 'استان با موفقیت ثبت شد.');
    }

    public function update(UpdateRequest $request, int $id)
    {
        $province = Province::query()->findOrFail($id);
        $province->update($request->all());
        $province->storeUserToAllCities($request);
        // ActivityLogHelper::updatedModel('استان بروز شد', $province);

        return redirect()->back()->with('success', 'استان با موفقیت ویرایش شد.');
    }

    public function destroy(int $id)
    {
        $province = Province::find($id);
        // ActivityLogHelper::deletedModel('استان حذف شد', $province);
        $province = Province::destroy($id);

        return redirect()->back()->with('success', 'استان با موفقیت حذف شد.');
    }
}
