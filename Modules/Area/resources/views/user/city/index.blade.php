@extends('layouts.user.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست شهر ها']]" />
        <x-create-button type="modal" target="createCityModal" title="شهر جدید" />
    </div>

    <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('user.cities.index',$province->id) }}" method="GET" class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{ request('name') }}"
                                    placeholder="عنوان">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="number" class="form-control" name="id" value="{{ request('id') }}"
                                    placeholder="شناسه">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select name="status" class="form-control" id="status">
                                    <option value="">همه</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : null }}>فعال</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : null }}>غیر فعال
                                    </option>
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
                            <button class="btn btn-primary btn-block" type="submit">جستجو <i
                                    class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('user.cities.index',$province->id) }}" class="btn btn-danger btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">شهر های استان {{ $province->name }} ({{ $cities->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام شهر','کاربر', 'وضعیت', 'تاریخ به روزرسانی', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($cities as $city)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->user ? $city->user->name : 'کارشناسی ثبت نشده' }}</td>
                            <td>@include('core::includes.status', ['status' => $city->status])</td>
                            <td>{{ verta($city->updated_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.edit-modal-button', [
                                    'target' => '#editCityModal-' . $city->id,
                                ])
                                @include('core::includes.delete-icon-button', [
                                    'model' => $city,
                                    'route' => 'user.cities.destroy',
                                    'disabled' => !$city->isDeletable(),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 6])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">{{ $cities->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}</x-slot>
            </x-table-component>
        </x-slot>
    </x-card>

    @include('area::user.city.includes.create-modal')
    @include('area::user.city.includes.edit-modal')
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
        $('#ProvinceSelection').select2({
            placeholder: 'انتخاب استان'
        });
        $('.CreateFormProvinceId').select2({
            placeholder: 'انتخاب استان'
        });
        $('#status').select2({
            placeholder: 'انتخاب وضعیت'
        });
        $(document).ready(function() {
            $('#province_id').select2({
                placeholder: "-- انتخاب استان --",
                allowClear: true
            });
        });
    </script>
@endsection
