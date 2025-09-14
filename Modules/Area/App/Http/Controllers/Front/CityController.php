<?php

namespace Modules\Area\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Area\App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::select('id','name')->get();

        return response()->json([
            'success' => true,
            'data' => ['cities' => $cities]
        ]);
    }
}