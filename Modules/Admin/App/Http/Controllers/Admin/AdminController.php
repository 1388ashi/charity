<?php

namespace Modules\Admin\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Admin\App\Http\Requests\Admin\AdminStoreRequest;
use Modules\Admin\App\Http\Requests\Admin\AdminUpdateRequest;
use Modules\Admin\App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
            $admins = Admin::query()
            ->latest('id')
            ->select(['id', 'name', 'mobile', 'last_login', 'created_at'])
            ->paginate();

        return view('admin::admin.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin::admin.admin.create');
    }

    public function store(AdminStoreRequest $request): RedirectResponse
    {
        $admin = Admin::create($request->validated());

        if ($request->permissions) {
            $admin->givePermissions($request->input('permissions'));
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'ادمین با موفقیت ثبت شد.');
    }

    public function show(Admin $admin)
    {
        return view('admin::admin.admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        // $permissions = Permission::where('guard_name', 'admin')->get(['id', 'name', 'label']);

        return view('admin::admin.admin.edit', compact('admin'));
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        $admin->update($request->all());

        return redirect()->route('admin.admins.index')
            ->with('success', 'ادمین با موفقیت به روزرسانی شد.');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'ادمین با موفقیت حذف شد.');
    }
}
