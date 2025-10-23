<?php

namespace Modules\Partner\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\Core\Classes\CoreSettings;
use Modules\Core\Classes\ManuallSms;
use Modules\Partner\App\Models\Note;
use Modules\Partner\App\Models\PartnerGroup;
use Modules\Sms\Sms;
use Modules\User\App\Models\User;

class PartnerController extends Controller
{
    public function management()
    {
        $user = auth('user')->user()->load('cities', 'provinces');

        return view('partner::management.index',compact('user'));
    }
    public function provinceManagement($province_id)
    {
        $status = request('status');
        $partnerGroups = PartnerGroup::with('city:id,name,province_id,user_id','city.user:id,name')
                ->provinceFilters()->where('province_id',$province_id)->latest('id')->paginate(20);
        $cities = City::where('province_id',$province_id)->get();
        $province = Province::select('id','name')->findOrFail($province_id);

        return view('partner::management.province-partners',compact('partnerGroups','cities','province'));
    }
    public function cityManagement($city_id)
    {
        $status = request('status');
        $partnerGroups = PartnerGroup::cityFilters()->where('city_id',$city_id)->latest('id')->paginate(20);
        $city = City::select('id','name')->findOrFail($city_id);

        return view('partner::management.city-partners',compact('partnerGroups','city'));
    }

    public function show(PartnerGroup $partnerGroup)
    {
        $notes = Note::where('partner_group_id',$partnerGroup->id)->where('user_id',$partnerGroup->city->user->id)->get();

        return view('partner::management.show',compact('partnerGroup','notes'));
    }
    public function updateStatus(PartnerGroup $partnerGroup, Request $request)
    {
        $partnerGroup->update(['status' => $request->status,'status_description' => $request->status_description]);
        $partnerPhone = $partnerGroup->partners()->first()?->phone;
        $pattern = app(CoreSettings::class)->get('sms.patterns.create_partner_to_city');
        $output = ManuallSms::partnerChangeStatus(
            $pattern,
            $partnerPhone,
            config("partner.statuses.{$partnerGroup->status}"),
        );
        if ($output['status'] != 200){
            Log::debug('', [$output]);
        }

        return redirect()->back()->with('success', 'وضعیت با موفقیت به روزرسانی شد.');
    }
    public function storeNote(Request $request, $groupId)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:2000'],
        ]);

        Note::create([
            'partner_group_id' => $groupId,
            'user_id'          => auth('user')->user()->id,
            'description'      => $request->description,
        ]);

        return redirect()->back()->with('success', 'یادداشت با موفقیت ذخیره شد');
    }
}
