<?php

namespace Modules\Partner\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Province;
use Modules\Partner\App\Models\Note;
use Modules\Partner\App\Models\PartnerGroup;

class PartnerController extends Controller
{
    public function index()
    {
        $status = request('status');
        $basePartnerGroups = PartnerGroup::with('province:id,name','city:id,name,province_id,user_id','city.user:id,name')->latest('id');
        $partnerGroupsForStatus = $basePartnerGroups->paginate(20);
        $partnerGroups = $basePartnerGroups->adminFilters()->paginate(20);
        $allStatuses = PartnerGroup::$statuses;
        $provinces = Province::select('id','name')->get();

        return view('partner::admin.index',compact('partnerGroups','provinces','allStatuses','partnerGroupsForStatus'));
    }
    public function show($id)
    {
        $partnerGroup = PartnerGroup::findOrfail($id);
        $notes = Note::where('partner_group_id',$partnerGroup->id)->where('user_id',$partnerGroup->city->user->id)->get();
        
        return view('partner::admin.show',compact('partnerGroup','notes'));
    }
    public function update()
    {
        return view('partner::index');
    }
}
