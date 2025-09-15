<?php

namespace Modules\Setting\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Modules\Setting\App\Http\Requests\SettingDestroyRequest;
use Modules\Setting\App\Http\Requests\SettingStoreRequest;
use Modules\Setting\App\Http\Requests\SettingUpdateRequest;
use Modules\Setting\App\Models\Setting;

class SettingController extends Controller
{
    public function index(): Renderable
    {
        $groups = collect(Setting::getAllGroups());

        return view('setting::admin.index', compact('groups'));
    }

    /**
     * Display a listing of the resource.
     */
    public function store(SettingStoreRequest  $request, string $group)
    {
        $validated = $request->validated();
        $validated['group'] = $group;
        Setting::query()->create($validated);

        return redirect()->route('admin.settings.edit', $group)
            ->with('success', 'کلید تنظیمات با موفقیت ثبت شد');
    }

    public function edit(string $group): Renderable
    {
        $validGroups = array_keys(Setting::getAllGroups());
        abort_unless(in_array($group, $validGroups), 403, 'Invalid group name');

        $settingTypes = Setting::query()->where('group', $group)->get()->groupBy('type');
        $types = Setting::getAllTypes();

        return view('setting::admin.edit', compact('settingTypes', 'group', 'types'));
    }
    public function update(SettingUpdateRequest $request): RedirectResponse
    {
        $inputs = $request->except(['_token', '_method']);
        foreach ($inputs as $name => $text) {
            if ($setting = Setting::where('name', $name)->first()) {
                if (in_array($setting->type, ['image', 'video']) && $text->isValid()) {
                    $setting->uploadFile($text);
                    $setting->refresh();
                    $text = $setting->file['url'];
                }else{
                    $setting->update(['value' => $text]);
                }
            }
        }

        return redirect()->back()->with('success', 'کلید با موفقیت ویرایش شد.');
    }

    public function destroy(SettingDestroyRequest $request): RedirectResponse
    {
        Setting::query()
            ->where('name', $request->input('name'))
            ->delete();

        return redirect()->back()
            ->with('success', 'کلید با موفقیت حذف شد!');
    }

    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted
     */
    public function deleteFile(Setting $setting): RedirectResponse
    {
        abort_if(!in_array($setting->type, ['image', 'video']), 403);

        $setting->deleteMedia($setting->file['id']);
        $setting->update(['value' => null]);

        return redirect()->back()
            ->with('success', 'فایل با موفقیت حذف شد');
    }
}
