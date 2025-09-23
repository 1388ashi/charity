<div class="sticky">
    <div class="horizontal-main hor-menu clearfix">
        <div class="horizontal-mainwrapper container clearfix">
            <nav class="horizontalMenu clearfix">
                <ul class="horizontalMenu-list">
                    <li aria-haspopup="true">
                        <a href="{{ route('user.dashboard') }}" class="sub-icon"><i class="feather feather-home hor-icon"></i>داشبورد</a>
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{ route('user.cities-management') }}" class="sub-icon">
                            <i class="feather feather-clipboard hor-icon"></i>مدیریت شهر ها
                        </a> 
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{ route('user.management.companions') }}" class="sub-icon">
                            <i class="feather feather-users hor-icon"></i>همیاران
                        </a> 
                    </li>
                    <li aria-haspopup="true">
                        <a href="{{ route('user.management.partners') }}" class="sub-icon">
                            <i class="feather feather-file-text hor-icon"></i>درخواست های زوجین
                        </a> 
                    </li>
                    <li aria-haspopup="true">
                        <a href="#" class="sub-icon">
                            <i class="fe fe-bar-chart-2 hor-icon"></i>گزارشات <i class="fa fa-angle-down horizontal-icon"></i>
                        </a>
                        <ul class="sub-menu">
                            <li><a aria-haspopup="true" href="{{ route('user.reports.partners-aggregate') }}" class="slide-item">گزارش جمعی درخواست های زوجین</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
