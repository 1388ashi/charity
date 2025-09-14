<?php

namespace Modules\Report\App\Http\Controllers\User;

use Modules\Report\App\Http\Controllers\BaseReportController;

class ReportController extends BaseReportController
{
    protected string $viewPrefix = 'user';
 
    protected function filterCitiesQuery($query)
    {
        return $query->where('user_id', auth('user')->id());
    }
    public function management()
    {
        $user = auth('user')->user()->load('cities', 'provinces');

        return view('report::user.partners-detail',compact('user'));
    }
}
