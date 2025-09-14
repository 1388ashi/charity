@extends('layouts.admin.master')

@section('content')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fe fe-life-buoy ml-1"></i> داشبورد</a></li>
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
                    <p class="card-title">آخرین درخواست های ثبت شده</p>
                    <div class="card-options ">
                        <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-info ml-3">مشاهده
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
                                        <th>شناسه</th>
                                        <th>نام متقاضی</th>
                                        <th>شهر</th>
                                        <th>کارشناس شهر</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ ثبت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($partnerGroups as $partnerGroup)
                                        <tr class="border-bottom">
                                            <td class="text-center">
                                                <span class="avatar avatar-sm brround">{{ $loop->iteration }}
                                                </span>
                                            </td>
                                            <td>{{ $partnerGroup->id }}</td>
                                            <td>{{ $partnerGroup->partners[0]->name }}</td>
                                            <td>{{ $partnerGroup->city->name }}</td>
                                            <td>{{ $partnerGroup->city->user->name }}</td>
                                            <td>@include('partner::management.includes.statuses', ['status' => $partnerGroup->status])</td>
                                            <td>{{ verta($partnerGroup->created_at)->format('Y/m/d H:i') }}</td>
                                            <td>
                                                @include('core::includes.show-icon-button ', [
                                                    'model' => $partnerGroup,
                                                    'route' => 'admin.partners.show',
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
    </div>
@endsection
