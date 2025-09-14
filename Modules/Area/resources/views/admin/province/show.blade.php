@extends('layouts.admin.master')
@section('content')
    <div class="page-header">
        @php
            $items = [
                ['title' => 'لیست استان ها', 'route_link' => 'admin.provinces.index'],
                ['title' => 'لیست شهر ها'],
            ];
        @endphp
        <x-breadcrumb :items="$items" />
        <x-create-button type="modal" target="createCityModal" title="شهر جدید" />
    </div>

    <x-card>
        <x-slot name="cardTitle">شهر های استان {{ $province->name }} ({{ $province->cities->count() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام', 'وضعیت', 'تاریخ ثبت', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($province->cities as $city)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $city->name }}</td>
                            <td>@include('core::includes.status', ['status' => $city->status])</td>
                            <td>{{ verta($city->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.edit-modal-button', [
                                    'target' => '#editCityModal-' . $city->id,
                                ])
                                @include('core::includes.delete-icon-button', [
                                    'model' => $city,
                                    'route' => 'admin.cities.destroy',
                                    'disabled' => false,
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 5])
                    @endforelse
                </x-slot>
                <x-slot name="extraData"></x-slot>
            </x-table-component>
        </x-slot>
    </x-card>

    @include('area::admin.province.includes.create-city-modal')
    @include('area::admin.province.includes.edit-city-modal')
@endsection
