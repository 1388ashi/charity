@extends('layouts.user.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'مدیریت همیاران']]" />
    </div>

    <x-card>
        <x-slot name="cardTitle">مدیریت همیاران</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <div class="row mb-3 p-4 justify-content-center align-items-start text-center">
                <div class="col-12 col-lg-5 ps-lg-4 border-dark">
                    <h4 class="mb-3">مدیریت شهر ها:</h4>
                    <div class="row justify-content-center">
                        @forelse($user->cities as $city)
                            <div class="col-6 col-md-3 mb-2 d-flex">
                                <a 
                                    href="{{ route('user.companions.index',$city->id) }}"
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