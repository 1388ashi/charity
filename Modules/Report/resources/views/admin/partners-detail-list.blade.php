@extends('layouts.admin.master')

@section('styles')
<style>
    .add {
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    .inactive {
        opacity: 0.5;
    }
</style>
@endsection
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'گزارش جمعی درخواست های زوجین']]" />
        <a href="{{ route('admin.reports.partners-aggregate-cities',$city->id) }}" class="btn btn-outline-info btn-sm"><span class="fa fa-arrow-left"></span></a>
    </div>

     <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('admin.reports.partners-aggregate-list', $city->id) }}" method="GET" class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input class="form-control fc-datepicker" id="start_date_show" type="text"
                                    autocomplete="off" placeholder="از تاریخ" />
                                <input name="start_date" id="start_date_hide" type="hidden"
                                    value="{{ request('start_date') }}" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input class="form-control fc-datepicker" id="end_date_show" type="text"
                                    autocomplete="off" placeholder="تا تاریخ" />
                                <input name="end_date" id="end_date_hide" type="hidden"
                                    value="{{ request('end_date') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-6 col-12">
                            <button class="btn btn-primary btn-block btn-sm" type="submit">جستجو <i
                                    class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('admin.reports.partners-aggregate-list', $city->id) }}" class="btn btn-danger btn-sm btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">گزارش جمعی درخواست های زوجین شهر {{ $city->name }}</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="d-flex justify-content-around">
                <div class="mb-3 d-flex flex-wrap gap-2">
                    @php
                        $statusColors = [
                            'pending' => 'btn-light',
                            'new' => 'btn-primary',
                            'await_payment' => 'btn-rss',
                            'paid' => 'btn-success',
                            'rejected' => 'btn-danger',
                        ];

                        $statusCounts = [];
                        foreach ($partnersListStatus as $item) {
                            $status = $item->status;
                            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
                        }
                    @endphp
                    <a href="{{ route('admin.reports.partners-aggregate-list', $city->id) }}" 
                        class="btn btn-sm btn-dark ml-1">
                      همه آیتم ها
                    </a>
                    @foreach ($allStatuses as $statusKey => $statusLabel)
                        @php
                            $classes = [
                                'status-btn',
                                'btn',
                                'ml-1',
                                'btn-sm',
                                $statusColors[$statusKey] ?? 'btn-secondary',
                                request('status') == $statusKey ? 'add' : 'inactive',
                            ];
                        @endphp
                        <a href="{{ route('admin.reports.partners-aggregate-list', ['status' => $statusKey, 'city' => $city->id]) }}"
                        class="{{ implode(' ', $classes) }}">
                            {{ $statusLabel }} ({{ $statusCounts[$statusKey] ?? 0 }})
                        </a>
                    @endforeach     
                </div>
                <div>
                    کارشناس شهر: <b>{{$city->user->name}}</b>
                </div>
            </div>
            
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام متقاضی', 'شماره تماس', 'وضعیت','تاریخ ثبت', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($partnersList as $partnerGroup)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $partnerGroup->partners[0]->name }}</td>
                            <td>{{ $partnerGroup->partners[0]->phone }}</td>
                            <td>@include('partner::management.includes.statuses', ['status' => $partnerGroup->status])</td>
                            <td>{{ verta($partnerGroup->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.show-icon-button ', [
                                    'model' => $partnerGroup,
                                    'route' => 'user.management.partners.show',
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 6])
                    @endforelse
                </x-slot>
            </x-table-component>
        </x-slot>
    </x-card>
@endsection
@section('scripts')
    @include('core::includes.date-input-script', [
        'dateInputId' => 'start_date_hide',
        'textInputId' => 'start_date_show',
    ])

    @include('core::includes.date-input-script', [
        'dateInputId' => 'end_date_hide',
        'textInputId' => 'end_date_show',
    ])
@endsection