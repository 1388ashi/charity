@extends('layouts.user.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست درخواست ها']]" />
    </div>

    <x-card>
        <x-slot name="cardTitle">مدیریت درخواست ها</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <div class="row mb-3 p-4 justify-content-center align-items-start text-center">
                @if ($user->provinces->count() > 0)
                    <div class="col-12 col-lg-5 border-lg-end pe-lg-4 mb-4 mb-lg-0">
                        <h4 class="mb-3">مدیریت استان ها:</h4>
                        <div class="row justify-content-center">
                            @forelse($user->provinces as $province)
                                <div class="col-6 col-md-3 mb-2 d-flex">
                                    <a 
                                        href="{{ route('user.province.management.partners',$province->id) }}"
                                        class="btn btn-outline-primary w-100 equipment-btn btn-sm"
                                        data-id="{{ $province->id }}">
                                        {{ $province->name }}
                                    </a>
                                </div>
                            @empty
                            --
                            @endforelse
                        </div>
                    </div>
                @endif

                <div class="col-12 col-lg-5 ps-lg-4 {{$user->provinces->count() > 0 ?  'border' : ''}} border-dark border-left-0 border-top-0 border-bottom-0">
                    <h4 class="mb-3">مدیریت شهر ها:</h4>
                    <div class="row justify-content-center">
                        @forelse($user->cities as $city)
                            <div class="col-6 col-md-3 mb-2 d-flex">
                                <a 
                                    href="{{ route('user.city.management.partners',$city->id) }}"
                                    class="btn btn-outline-primary w-100 equipment-btn btn-sm"
                                    data-id="{{ $city->id }}">
                                    {{ $city->name }}
                                </a>
                            </div>
                        @empty
                        -
                        @endforelse
                    </div>
                </div>
            </div>
        </x-slot>
    </x-card>
@endsection
