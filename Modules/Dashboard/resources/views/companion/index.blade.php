@extends('layouts.companion.master')

@section('content')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('companion.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i>داشبورد</a></li>
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
        <div class="col-xl-6 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mt-0 d-flex justify-content-between align-items-center">
                                <span class="fs-16 text-right font-weight-semibold">لینک همیاری من :</span>
                                <p id="copyLink" 
                                    class="mb-0 text-left text-primary fs-16" 
                                    style="cursor: pointer;" 
                                    data-toggle="tooltip"
                                    data-original-title="برای دریافت لینک کلیک کنید">
                                    {{ env('APP_URL') . '/help-user?code=' . $companion->tokenCode->code }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <p class="card-title">آخرین کمک های اهدا شده</p>
                    <div class="card-options ">
                        <a href="{{ route('companion.help-user.index') }}" class="btn btn-outline-info ml-3">مشاهده
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
                                        <th>نام حامی</th>
                                        <th>شماره تماس</th>
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
                                            <td>{{ $item->helpUser->name }}</td>
                                            <td>{{ $item->helpUser->mobile }}</td>
                                            <td>
                                                @if ($item->type == 'cash')
                                                    نقدی ({{ number_format($item->amount) }} تومن)
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
@section('scripts')
    <script>
        document.getElementById("copyLink").addEventListener("click", function() {
            var text = this.innerText;
            
            navigator.clipboard.writeText(text).then(function() {
                alert("لینک کپی شد ✅");
            }, function(err) {
                alert("خطا در کپی کردن ❌");
            });
        });
    </script>
@endsection