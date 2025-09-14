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
        <a href="{{ route('admin.reports.partners-aggregate') }}" class="btn btn-outline-info btn-sm"><span class="fa fa-arrow-left"></span></a>
    </div>

    <x-card>
        <x-slot name="cardTitle">گزارش جمعی درخواست های زوجین استان {{$province->name}}</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="d-flex justify-content-around">
                <div>
                    <x-btn-statuses :statuses="$allStatuses" :totalRows="$totals"/>
                </div>
                <div class="d-flex flex-wrap gap-4">
                    @foreach ($citiesUserGroup as $userName => $cities)
                        <div class="p-2 border rounded">
                            <h6 class="mb-2">
                                کارشناس: <span class="text-primary">{{ $userName }}</span>
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($cities as $city)
                                    <span class="badge badge-light border">
                                        {{ $city->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام شهر', 'کارشناس', 'وضعیت درخواست ها', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($citiesReport as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>
                                <a class="w-100 h-100 d-inline-block" href="{{ route('admin.reports.partners-aggregate-list',$item->id) }}">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>
                                {!! $item->user_id && $item->user && $item->user->name
                                    ? $item->user->name
                                    : '<span class="text-danger">ندارد</span>' !!}
                            </td>
                            <td>
                                <x-show-status-partner :item="$item"/>
                            </td>
                            <td>
                                @include('core::includes.show-icon-button', [
                                    'model' => $item,
                                    'route' => 'admin.reports.partners-aggregate-list',
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 5])
                    @endforelse
                </x-slot>
            </x-table-component>
        </x-slot>
    </x-card>
@endsection
@section('scripts')
    <script>
        $('#provinceSelect').select2({
            placeholder: 'انتخاب استان'
        });
    </script>
@endsection