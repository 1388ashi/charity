<div class="sticky">
    <div class="horizontal-main hor-menu clearfix">
        <div class="horizontal-mainwrapper container clearfix">
            <nav class="horizontalMenu clearfix">
                <ul class="horizontalMenu-list">
                    <li aria-haspopup="true">
                        <a href="{{ route('admin.dashboard') }}" class="sub-icon"><i class="feather feather-home hor-icon"></i>داشبورد</a>
                    </li>
                    <li aria-haspopup="true">
                        <a href="#" class="">
                            <i class="feather feather-users hor-icon"></i>مدیریت کاربران<i class="fa fa-angle-down horizontal-icon"></i>
                        </a>
                        <ul class="sub-menu">
                            <li aria-haspopup="true"><a href="{{route('admin.admins.index')}}">مدیران</a></li>
                            <li aria-haspopup="true"><a href="{{route('admin.users.index')}}">کاربران</a></li>
                        </ul>
                    </li>
                    <li aria-haspopup="true">
                        <a href="#" class="sub-icon">
                            <i class="feather feather-clipboard hor-icon"></i>مناطق <i class="fa fa-angle-down horizontal-icon"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a aria-haspopup="true" href="{{ route('admin.provinces.index') }}" class="slide-item">استان</a></li>
                            <li><a aria-haspopup="true" href="{{ route('admin.cities-management') }}" class="slide-item">شهر</a></li>
                        </ul>
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{ route('admin.equipments.index') }}" class="sub-icon"><i class="feather feather-shopping-bag hor-icon"></i>تجهیزات</a>
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{ route('admin.partners.index') }}" class="sub-icon">
                            <i class="feather feather-file-text hor-icon"></i>درخواست های زوجین
                        </a> 
                    </li>
                    <li aria-haspopup="true">
                        <a href="#" class="sub-icon">
                            <i class="fe fe-bar-chart-2 hor-icon"></i>گزارشات <i class="fa fa-angle-down horizontal-icon"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a aria-haspopup="true" href="{{ route('admin.reports.partners-aggregate') }}" class="slide-item">گزارش جمعی درخواست های زوجین</a></li>
                            <li><a aria-haspopup="true" href="{{ route('admin.reports.companions') }}" class="slide-item">گزارش همیاران</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
