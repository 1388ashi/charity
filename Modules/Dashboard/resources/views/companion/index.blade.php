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
                                        <th>نام هامی</th>
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
                                                    تجهیزات: <span class="font-weight-bold">{{ $item->equipments->pluck('name')->join(', ') }}</span> 
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
