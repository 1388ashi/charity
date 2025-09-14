<?php

namespace Modules\Equipment\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Equipment\App\Http\Requests\Admin\StoreRequest;
use Modules\Equipment\App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::latest('id')->paginate();

        return view('equipment::admin.index', compact('equipments'));
    }

    public function store(StoreRequest $request)
    {
        Equipment::query()->create($request->validated());

        return redirect()->back()->with('success', 'تجهیزات با موفقیت ثبت شد.');
    }


    public function update(StoreRequest $request,Equipment $equipment)
    {
        $equipment->update($request->validated());

        return redirect()->back()->with('success', 'تجهیز با موفقیت بروزرسانی شد.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->back()->with('success', 'شهر با موفیت حذف شد.');
    }
}
