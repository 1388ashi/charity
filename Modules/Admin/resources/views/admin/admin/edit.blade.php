@extends('layouts.admin.master')

@section('content')
    <div class="page-header">
        @php
            $items = [
                ['title' => 'لیست همه ادمین ها', 'route_link' => 'admin.admins.index'],
                ['title' => 'ویرایش ادمین', 'route_link' => null],
            ];
        @endphp
        <x-breadcrumb :items="$items" />
    </div>

    <x-card>
        <x-slot name="cardTitle">ویرایش ادمین - کد {{ $admin->id }}</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-alert-danger />
            <form action="{{ route('admin.admins.update', $admin) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col">
                        <div
                            class="form-group">
                            <label for="name" class="control-label">نام و نام خانوادگی</label>
                            <span class="text-danger">&starf;</span>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                class="form-control" id="name"
                                placeholder="نام و نام خانوادگی را اینجا وارد کنید..." required autofocus>
                        </div>
                    </div>
                    <div class="col">
                        <div
                            class="form-group">
                            <label for="mobile" class="control-label">تلفن همراه</label>
                            <span class="text-danger">&starf;</span>
                            <input type="text" name="mobile" value="{{ old('mobile', $admin->mobile) }}"
                                class="form-control" id="mobile"
                                placeholder="تلفن همراه را اینجا وارد کنید..." required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div
                            class="form-group">
                            <label for="password" class="control-label">کلمه عبور</label>
                            <input type="password" name="password"
                                class="form-control" id="password"
                                placeholder="کلمه عبور را اینجا وارد کنید...">
                        </div>
                    </div>
                    <div class="col">
                        <div
                            class="form-group">
                            <label for="password_confirmation" class="control-label">تکرار کلمه عبور</label>
                            <input type="password" name="password_confirmation"
                                class="form-control" id="password_confirmation"
                                placeholder="تکرار کلمه عبور را اینجا وارد کنید...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <button class="btn btn-warning" type="submit">به روزرسانی</button>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
