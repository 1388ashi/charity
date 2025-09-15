<?php

namespace Modules\Setting\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Modules\Setting\App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();

        $groupedSettings = [];

        foreach ($settings as $setting) {
            if ($setting->type === 'image' && isset($setting->file['url'])) {
                $setting->value = $setting->file['url'];
            }

            $group = $setting->group ?? 'default';
            $name = $setting->name;

            if (!isset($groupedSettings[$group])) {
                $groupedSettings[$group] = [];
            }

            $groupedSettings[$group][$name] = $setting;
        }

        return response()->json([
            'settings' => $groupedSettings,
        ]);
    }
}
