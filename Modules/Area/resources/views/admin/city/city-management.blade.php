@extends('layouts.admin.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'مدیریت شهر ها']]" />
    </div>

    <x-card>
        <x-slot name="cardTitle">مدیریت شهر ها</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <div class="row mb-3 p-4 justify-content-center align-items-start text-center">
                <div class="col-12 col-lg-5 border-lg-end pe-lg-4 mb-4 mb-lg-0">
                    <div class="row justify-content-center">
                     @forelse($provinces as $province)
                          @php
                                $totalCities = $province->cities->count();
                                $citiesWithoutUser = $province->cities->whereNull('user_id')->count();

                                if ($totalCities > 0) {
                                    if ($citiesWithoutUser === $totalCities) {
                                        $icon = 'fa fa-times-circle text-danger';
                                        $title = 'هیچ شهری کارشناس ندارد';
                                    } elseif ($citiesWithoutUser > 0) {
                                        $icon = 'fa fa-exclamation-triangle text-warning';
                                        $title = $citiesWithoutUser . ' شهر بدون کارشناس هستند';
                                    } else {
                                        $icon = 'fa fa-check-circle text-success';
                                        $title = 'تمامی شهرها کارشناس دارند';
                                    }
                                } else {
                                    $icon = 'fa fa-minus-circle text-secondary';
                                    $title = 'هیچ شهری در این استان ثبت نشده است';
                                }
                            @endphp

                        <div class="col-6 col-md-3 mb-2 d-flex">
                            <a 
                                href="{{ route('admin.cities.index', $province->id) }}"
                                class="btn btn-outline-primary w-100 equipment-btn"
                                data-id="{{ $province->id }}"
                                data-toggle="tooltip"
                                data-original-title="{{ $title }}" 
                            >
                                {{ $province->name }}

                                @if ($icon)
                                    <i class="{{ $icon }}"></i>
                                @endif
                            </a>
                        </div>
                    @empty
                        --
                    @endforelse
                    </div>
                </div>
            </div>
        </x-slot>
    </x-card>
@endsection
