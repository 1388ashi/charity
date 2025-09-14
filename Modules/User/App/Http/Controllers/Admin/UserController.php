<?php

namespace Modules\User\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\App\Http\Requests\Admin\StoreRequest;
use Modules\User\App\Http\Requests\Admin\UpdateRequest;
use Modules\User\App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->filters()
            ->latest('id')
            ->paginate();

        return view('user::admin.index', compact('users'));
    }

    public function create()
    {
        return view('user::admin.create');
    }

    public function store(StoreRequest $request) {
        User::create($request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت ثبت شد.');
    }

    public function show(User $user)
    {
        $user->load(['provinces','cities']);

        return view('user::admin.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user::admin.edit',compact('user'));
    }

    public function update(UpdateRequest $request,User $user) {
        $user->update($request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت به روزرسانی شد.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
