@extends('layouts.admin.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست درخواست های زوجین']]" />
    </div>

    <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('admin.partners.index') }}" method="GET" class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select id="provinceSelect" name="province_id" class="form-control select2">
                                    <option value="" disabled selected>-- استان را انتخاب کنید --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : null }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select id="citySelect" name="city_id" class="form-control select2">
                                    <option value="" disabled selected>-- شهر را انتخاب کنید --</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-lg-4">
                            <div class="form-group">
                                <select name="status" class="form-control select2">
                                    <option value="" selected>-- وضعیت را انتخاب کنید --</option>
                                    @foreach (config('partner.statuses') as $name => $label)
                                        <option value="{{ $name }}"
                                            {{ request('status') == $name ? 'selected' : null }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                            <button class="btn btn-primary btn-sm btn-block" type="submit">جستجو <i
                                    class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('admin.partners.index') }}" class="btn btn-danger btn-sm btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">لیست درخواست های زوجین ({{ $partnerGroups->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
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
                    foreach ($partnerGroupsForStatus as $item) {
                        $status = $item->status;
                        $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
                    }
                @endphp
                <a href="{{ route('admin.partners.index') }}" 
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
                    <a href="{{ route('admin.partners.index', ['status' => $statusKey]) }}"
                    class="{{ implode(' ', $classes) }}">
                        {{ $statusLabel }} ({{ $statusCounts[$statusKey] ?? 0 }})
                    </a>
                @endforeach

               
            </div>
            @include('components.errors')
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف','شناسه','نام متقاضی','استان','شهر','مدیر شهر','وضعیت','تاریخ ثبت', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($partnerGroups as $partnerGroup)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $partnerGroup->id }}</td>
                            <td>{{ $partnerGroup->partners[0]->name }}</td>
                            <td>{{ $partnerGroup->province->name }}</td>
                            <td>{{ $partnerGroup->city->name }}</td>
                            <td>{{ $partnerGroup->city->user?->name ?? '-' }}</td>
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
                        @include('core::includes.data-not-found-alert', ['colspan' => 7])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">{{ $partnerGroups->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}</x-slot>
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

    <script>
        $('#city_id').select2({
            placeholder: 'انتخاب شهر'
        });
        $('#status').select2({
            placeholder: 'انتخاب وضعیت'
        });

        $('#provinceSelect').on('change', function() {
            var provinceId = $(this).val();
            if(provinceId) {
                $.ajax({
                    url: '/cities/' + provinceId,
                    type: 'GET',
                    success: function(data) {
                        var citySelect = $('#citySelect');
                        citySelect.empty();
                        citySelect.append('<option value="" disabled selected>-- شهر را انتخاب کنید --</option>');
                        $.each(data, function(key, city) {
                            citySelect.append('<option value="'+city.id+'">'+city.name+'</option>');
                        });
                        citySelect.trigger('change'); 
                    }
                });
            }
        });
    </script>
@endsection
