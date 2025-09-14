@extends('layouts.admin.master')

@section('content')
    <!--  Page-header opened -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.admins.index') }}">لیست ادمین ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">نمایش ادمین</li>
        </ol>
    </div>
    <!--  Page-header closed -->

    @include('components.errors')

    <!-- row opened -->
    <div class="row">
        <div class="col-lg-12" >
            <div class="bg-white widget-user mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <ul>
                                <li><strong>نام و نام خانوادگی: </strong> {{ $admin->name }}</li>
                                <li><strong>تلفن همراه: </strong> {{ $admin->mobile }}</li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul>
                                <li><strong>آخرین ورود: </strong> {{ $admin->getJalaliLastLogin() }}</li>
                                <li><strong>تاریخ ثبت: </strong> {{ $admin->getJalaliCreatedAt() }}</li>
                            </ul>
                        </div>
                        {{-- <div class="col">
                            <ul>
                                <li><strong>نقش کاربری: </strong> {{ $admin->hasRole('super_admin') ? 'مدیر ارشد' : 'مدیر' }}</li>
                                <li><strong>نام ایجادکننده: </strong> {{ $admin->creator->name }}</li>
                                <li><strong>نام آخرین ویرایش کننده: </strong> {{ $admin->updater->name }}</li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
