@extends('layouts.admin.master')

@section('content')
    <div class="page-header">
        @php($items = [['title' => 'لیست کاربران', 'route_link' => 'admin.users.index'], ['title' => 'ویرایش کاربر']])
        <x-breadcrumb :items="$items" />
    </div>

    <x-card>
        <x-slot name="cardTitle">ویرایش کاربر</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="save" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">نام کامل</label>
                            <span class="text-danger">&starf;</span>
                            <input type="text" name="name" value="{{ old('name',$user->name) }}" class="form-control"
                                id="name" placeholder="نام کامل را وارد کنید..." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile" class="control-label">شماره موبایل</label>
                            <span class="text-danger">&starf;</span>
                            <input type="text" name="mobile" value="{{ old('mobile',$user->mobile) }}" class="form-control"
                                id="mobile" placeholder="شماره موبایل را وارد کنید..." required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="national_code" class="control-label">کد ملی</label>
                            <span class="text-danger">&starf;</span>
                            <input type="text" name="national_code" value="{{ old('national_code',$user->national_code) }}"
                            class="form-control" id="national_code" placeholder="کد ملی را وارد کنید..." required>
                        </div>
                    </div>
                    
                </div>
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="status" value="1" {{ old('status', 1) == 1 ? 'checked' : null }}/>
                        <span class="custom-control-label">وضعیت</span>
                        </label>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-warning">بروزرسانی</button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-card>
@endsection
