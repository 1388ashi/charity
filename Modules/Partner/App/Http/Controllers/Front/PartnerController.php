<?php

namespace Modules\Partner\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\Equipment\App\Models\Equipment;
use Modules\Partner\App\Http\Requests\Front\StoreRequest;
use Modules\Partner\App\Models\Partner;
use Modules\Partner\App\Models\PartnerGroup;

class PartnerController extends Controller
{
    
    public function create()
    {
        $provinces = Province::select('id', 'name','user_id')->active()->get();
        $equipments = Equipment::all();
        $educations = Partner::$educations;

        return view('partner::front.create',compact('equipments','educations','provinces'));
    }
    public function store(StoreRequest $request)
    { 
        //TODO
        //in try catch biad o baadesh sms bereh be user == $request->city_id;
        // yek darkhast jadid dar shahr city_name sabt shod;
        $group = PartnerGroup::create([
            'city_id' => $request->city_id,
            'province_id' => $request->province_id,
            'marriage_date' => $request->marriage_date,
            'marriage_location' => $request->marriage_location,
            'marriage_certificate_no' => $request->marriage_certificate_no,
            'notes' => $request->notes,
        ]);
        foreach ($request->partners as $partnerData) {
            $group->partners()->create([
                'gender' => $partnerData['gender'],
                'name' => $partnerData['name'],
                'birth_date' => $partnerData['birth_date'],
                'national_code' => $partnerData['national_code'], 
                'phone' => $partnerData['phone'],
                'address' => $partnerData['address'],
                'job' => $partnerData['job'],
                'education' => $partnerData['education'],
            ]);
        }

        if ($request->filled('equipments')) {
            $group->equipments()->attach($request->equipments);
        }

        return redirect()->back()->with('success', 'اطلاعات با موفقیت ثبت شد ✅');
    }
}
