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
    </div>

    <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('admin.reports.partners-aggregate') }}" method="GET" class="col-12">
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
                    </div>
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-6 col-12">
                            <button class="btn btn-sm btn-primary btn-block" type="submit">جستجو <i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('admin.reports.partners-aggregate') }}" class="btn btn-sm btn-danger btn-block">حذف همه فیلترها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">گزارش جمعی درخواست های زوجین</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="mb-3">
                <x-btn-statuses :statuses="$allStatuses" :totalRows="$totals"/>
            </div>
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'استان', 'کارشناس استان', 'وضعیت درخواست ها', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($provincesReport as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>
                                <a class="w-100 h-100 d-inline-block" href="{{ route('admin.reports.partners-aggregate-cities',$item->id) }}">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>{{ $item->user?->name ?? '-' }}</td>
                            <td>
                                <x-show-status-partner :item="$item"/>
                            </td>
                            <td>
                                @include('core::includes.show-icon-button', [
                                    'model' => $item,
                                    'route' => 'admin.reports.partners-aggregate-cities',
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