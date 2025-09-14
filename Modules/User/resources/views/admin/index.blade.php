@extends('layouts.admin.master')

@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست کاربران']]" />
        <x-create-button route="admin.users.create" title="کاربر جدید" />
    </div>

    <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('admin.users.index') }}" method="GET" class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" value="{{ request('name') }}"
                                       placeholder="نام کارشناس">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" name="national_code" value="{{ request('national_code') }}"
                                       placeholder="کد ملی">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" class="form-control" name="mobile" value="{{ request('mobile') }}"
                                       placeholder="شماره موبایل">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-6 col-12">
                            <button class="btn btn-sm btn-primary btn-block" type="submit">جستجو <i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-danger btn-block">حذف همه فیلترها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">کاربران ({{ $users->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام', 'موبایل', 'کد ملی','تاریخ ثبت', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($users as $user)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->national_code ?? '-' }}</td>
                            {{-- <td>@include('core::includes.status', ['status' => $user->status])</td> --}}
                            <td>{{ verta($user->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.show-icon-button', [
                                    'model' => $user,
                                    'route' => 'admin.users.show',
                                ])
                                @include('core::includes.edit-icon-button', [
                                    'model' => $user,
                                    'route' => 'admin.users.edit',
                                ])
                                @include('core::includes.delete-icon-button', [
                                    'model' => $user,
                                    'route' => 'admin.users.destroy',
                                    'disabled' => false,
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 7])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">{{ $users->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}</x-slot>
            </x-table-component>
        </x-slot>
    </x-card>
@endsection
