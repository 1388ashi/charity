<?php

namespace Modules\Area\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Area\App\Models\Province;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::active()->with('cities:id,name,province_id')->get();

        return response()->json([
            'success' => true,
            'data' => ['provinces' => $provinces]
        ]);
    }
}