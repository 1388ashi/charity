<?php

namespace Modules\Partner\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Area\App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Area\App\Models\Province;
use Modules\Core\Classes\CoreSettings;
use Modules\Core\Classes\ManuallSms;
use Modules\Equipment\App\Models\Equipment;
use Modules\Partner\App\Http\Requests\Front\StoreRequest;
use Modules\Partner\App\Models\Partner;
use Modules\Partner\App\Models\PartnerGroup;
use Modules\Sms\Sms;

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
        //TODO:
        //in try catch biad o baadesh sms bereh be user == $request->city_id;
        // yek darkhast jadid dar shahr city_name sabt shod;
         try {
            DB::beginTransaction();
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

            //sms to person
            $partnerPhone = $group->partners()->first()?->phone;
            $pattern = app(CoreSettings::class)->get('sms.patterns.create_partner_to_person');
            $output = Sms::pattern($pattern)
                ->data([
                    'token' => '.',
                ])
                ->to([$partnerPhone])
                ->send();

            if ($output['status'] != 200) {
                Log::debug('SMS sending failed', [$output]);
            }
            //sms to user city
            if ($group->city->user && $group->city->user->mobile) {
                $pattern = app(CoreSettings::class)->get('sms.patterns.create_partner_to_city');
                $output = ManuallSms::partnerCreate(
                    $pattern,
                    $group->city->user->mobile,
                    $group->city->name,
                );
                if ($output['status'] != 200){
                    Log::debug('', [$output]);
                }
            }

            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getTraceAsString());
            return redirect()->back()->with('error', 'مشکل در ثبت درخواست.'. $throwable->getMessage());
        }
       

        return redirect()->back()->with('success', 'اطلاعات با موفقیت ثبت شد ✅');
    }
}
