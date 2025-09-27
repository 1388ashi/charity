@extends('layouts.help-user.master')
@section('content')
    <div class="page-header">
        <a   
            href="{{ route('help-user.index',['code' => $code]) }}"   
            class="btn btn-primary btn-sm">  
            لیست کمک ها  
        </a>  
    </div>

    <x-card>
        <x-slot name="cardTitle">اطلاعات کاربری</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <div class="d-flex justify-content-center align-items-center" style="min-height: 10vh;">
                <form action="{{ route('help-user.update', $user->id) }}" class="col-12 col-md-8 col-lg-6 p-0" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <div class="form-group">
                                    <label for="name" class="control-label">نام و نام خانوادگی</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control" id="name"
                                        placeholder="نام کامل خود را اینجا وارد کنید..." autofocus>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="national_code" class="control-label">کد ملی </label>
                                    <input type="text" name="national_code" value="{{ old('national_code', $user->national_code) }}"
                                        class="form-control" id="national_code"
                                        placeholder="کد ملی خود را اینجا وارد کنید...">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4">
                                به روزرسانی اطلاعات
                                <i class="fa fa-hand-o-up text-white mt-1 mr-1"></i>
                            </button>
                            <a type="submit" href="{{ route('help-user.help-page',['code' => $code]) }}" class="btn btn-info px-4">
                                کمک جدید
                                <i class="fa fa-plus text-white mt-1 mr-1"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>
@endsection
