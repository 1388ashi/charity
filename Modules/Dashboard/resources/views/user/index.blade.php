@extends('layouts.user.master')

@section('content')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
        </ol>
        <div class="mt-3 mt-lg-0">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    {{-- <a href="{{ route('admin.products.index') }}"> --}}
                                        <div class="mt-0 text-right">
                                            <span class="fs-16 font-weight-semibold">جمع کمک های نقدی امروز :</span>
                                            <p class="mb-0 mt-1 text-primary fs-20"> {{ number_format($todayTotal) }} 
                                                @if($todayTotal > 0)
                                                    <span class="font-weight-bold fs-18">
                                                        تومن
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    {{-- </a> --}}
                                </div>
                                <div class="col-3">
                                    <div class="icon1 bg-primary my-auto float-left">
                                        <i class="fa fa-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    {{-- <a href="{{ route('admin.comments.index') }}"> --}}
                                        <div class="mt-0 text-right">
                                            <span class="fs-16 font-weight-semibold">جمع کمک های نقدی هفته اخیر :</span>
                                            <p class="mb-0 mt-1 text-pink  fs-20">{{ number_format($weekTotal) }} 
                                                @if($weekTotal > 0)
                                                    <span class="font-weight-bold fs-18">
                                                        تومن
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    {{-- </a> --}}
                                </div>
                                <div class="col-3">
                                    <div class="icon1 bg-pink my-auto float-left">
                                        <i class="fa fa-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    {{-- <a href="{{ route('admin.articles.index') }}"> --}}
                                        <div class="mt-0 text-right">
                                            <span class="fs-16 font-weight-semibold">جمع کمک های نقدی ماه اخیر :</span>
                                            <p class="mb-0 mt-1 text-success fs-20"> {{ number_format($monthTotal) }}  
                                                @if($monthTotal > 0)
                                                    <span class="font-weight-bold fs-18">
                                                        تومن
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    {{-- </a> --}}
                                </div>
                                <div class="col-3">
                                    <div class="icon1 bg-secondary my-auto float-left">
                                      <i class="fa fa-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    {{-- <a href="{{ route('admin.resumes.index') }}"> --}}
                                        <div class="mt-0 text-right">
                                            <span class="fs-16 font-weight-semibold">جمع کل کمک های نقدی :</span>
                                            <p class="mb-0 mt-1 text-success fs-20"> {{ number_format($allTotal) }}  
                                                @if($allTotal > 0)
                                                    <span class="font-weight-bold fs-18">
                                                        تومن
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    {{-- </a> --}}
                                </div>
                                <div class="col-3">
                                    <div class="icon1 bg-success my-auto float-left">
                                        <i class="fa fa-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <p class="card-title">آخرین درخواست های ثبت شده</p>
                    <div class="card-options ">
                        <a href="{{ route('user.management.partners') }}" class="btn btn-outline-info ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive attendance_table border-top">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table mb-0 text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>شناسه</th>
                                        <th>نام متقاضی</th>
                                        <th>شهر</th>
                                        <th>کارشناس شهر</th>
                                        <th>تاریخ ثبت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($partnerGroups as $partnerGroup)
                                        <tr class="border-bottom">
                                            <td class="text-center">
                                                <span class="avatar avatar-sm brround">{{ $partnerGroup->id }}
                                                </span>
                                            </td>
                                            <td>{{ $partnerGroup->partners[0]->name }}</td>
                                            <td>{{ $partnerGroup->city->name }}</td>
                                            <td>{{ $partnerGroup->city->user->name }}</td>
                                            <td>{{ verta($partnerGroup->created_at)->format('Y/m/d H:i') }}</td>
                                            <td>
                                                @include('core::includes.show-icon-button ', [
                                                    'model' => $partnerGroup,
                                                    'route' => 'user.management.partners.show',
                                                ])
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td colspan="7">
                                                <p class="text-danger" style="display: flex;justify-content: center !important">
                                                    <strong>در حال حاضر هیچ درخواستی یافت نشد!</strong></p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <p class="card-title">آخرین کمک های اهدا شده</p>
                    <div class="card-options ">
                        <a href="{{ route('user.reports.companions-management') }}" class="btn btn-outline-info ml-3">مشاهده
                            همه</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive attendance_table border-top">
                        <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table mb-0 text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>ردیف</th>
                                        <th>همیار مرتبط</th>
                                        <th>نام حامی</th>
                                        <th>نوع کمک</th>
                                        <th>تاریخ ثبت</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($helps as $item)
                                        <tr class="border-bottom">
                                            <td class="text-center">
                                                <span class="avatar avatar-sm brround">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>{{ $item->companion ? $item->companion->name : 'آزاد(بدون همیار)' }}</td>
                                            <td>{{ $item->helpUser->name . ' - ' . $item->helpUser->mobile }}</td>
                                            <td>
                                                @if ($item->type == 'cash')
                                                    نقدی ({{ number_format($item->amount) }} تومان)
                                                @else
                                                    تجهیزات: 
                                                    <span class="font-weight-bold">
                                                        @foreach ($item->equipments as $equipment)
                                                            {{ $equipment->name }}
                                                            @if($equipment->pivot->quantity > 1)
                                                                ({{ $equipment->pivot->quantity }})
                                                            @endif
                                                            @if(!$loop->last), @endif
                                                        @endforeach
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ verta($item->created_at)->format('Y/m/d H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <p class="text-danger" style="display: flex;justify-content: center !important">
                                                    <strong>در حال حاضر هیچ کمکی یافت نشد!</strong></p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
