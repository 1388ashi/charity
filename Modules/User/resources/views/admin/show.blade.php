@extends('layouts.user.master')

@section('content')
    <div class="page-header">
        @php
            $items = [
                        ['title' => 'لیست کاربران', 'route_link' => 'admin.users.index'],
                        ['title' => 'اطلاعات کاربر', 'route_link' => null]
                    ]
        @endphp
        <x-breadcrumb :items="$items" />
    </div>

    <x-card>
        <x-slot name="cardTitle">نمایش اطلاعات کاربر ({{ $user->name }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-6">
                        <strong>کد ملی:</strong> {{ $user->national_code }}
                    </div>
                    <div class="col-6">
                        <strong>موبایل:</strong> {{ $user->mobile }}
                    </div>
                </div>
                <div class="row mb-3">
                    @if ($user->provinces->count() > 0)
                    <div class="col-6">
                        <strong>استان های مدیریت:</strong>
                        @foreach ($user->provinces as $key => $province)
                            {{$province->name}}
                            @if($key < $user->provinces->count() - 1),@endif
                        @endforeach
                    </div>
                    @endif
                    @if ($user->cities->count() > 0)
                    <div class="col-6">
                        <strong>شهر های مدیریت:</strong>
                        @foreach ($user->cities as $key => $city)
                            {{$city->name}}
                            @if($key < $user->cities->count() - 1),@endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-card>
@endsection
