@extends('layouts.admin.master')

@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست همه ادمین ها']]" />
        <x-create-button route="admin.admins.create" title="ادمین جدید" />
    </div>

    <x-card>
        <x-slot name="cardTitle">لیست همه ادمین ها ({{ $admins->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>شماره موبایل</th>
                        <th>تاریخ ثبت</th>
                        <th>عملیات</th>
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse($admins as $admin)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->mobile ?? '-' }}</td>
                            <td>{{ verta($admin->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.edit-icon-button', [
                                    'model' => $admin,
                                    'route' => 'admin.admins.edit',
                                ])
                                @include('core::includes.delete-icon-button', [
                                    'model' => $admin,
                                    'route' => 'admin.admins.destroy',
                                    'disabled' => false,
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 5])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">
                    {{ $admins->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}
                </x-slot>
            </x-table-component>
        </x-slot>
    </x-card>

@endsection