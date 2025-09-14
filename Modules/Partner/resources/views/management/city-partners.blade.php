@extends('layouts.user.master')
@section('content')
    <div class="page-header">
        @php
            $items = [
                ['title' => 'لیست مناطق', 'route_link' => 'user.management.partners'],
                ['title' => 'لیست درخواست های زوجین', 'route_link' => null],
            ];
        @endphp
        <x-breadcrumb :items="$items" />
    </div>

    <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('user.city.management.partners',$city->id) }}" method="GET" class="col-12">
                    <div class="row">
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
                            <button class="btn btn-primary btn-block btn-sm" type="submit">جستجو <i
                                    class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('user.city.management.partners',$city->id) }}" class="btn btn-danger btn-sm btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">لیست درخواست های زوجین شهر {{ $city->name }} ({{ $partnerGroups->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف','شناسه','شهر','کارشناس شهر','وضعیت','تاریخ ثبت', 'عملیات'])
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
                            <td>{{ $partnerGroup->city->name }}</td>
                            <td>{{ $partnerGroup->city->user->name }}</td>
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
        $('#status').select2({
            placeholder: 'انتخاب وضعیت'
        });
    </script>
@endsection
