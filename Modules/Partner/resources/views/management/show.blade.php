@extends('layouts.user.master')

@section('content')
    <div class="page-header">
        @php
            $items = [
                        ['title' => 'لیست مناطق', 'route_link' => 'user.management.partners'],
                        ['title' => 'اطلاعات درخواست', 'route_link' => null],
                    ] 
        @endphp
        <x-breadcrumb :items="$items" />
        <x-create-button type="modal" target="createNoteModal" title="ثبت یادداشت جدید" />
        {{-- <a   
            target="_blank"
            href="{{ route('admin.orders.print', $order->id) }}"   
            class="btn btn-primary btn-sm btn-info">  
            چاپ پرونده
            <i class="fa fa-print"></i>  
        </a>   --}}
    </div>

    <x-card>
        <x-slot name="cardTitle">نمایش درخواست کد ({{ $partnerGroup->id }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-3">
                        <strong>استان:</strong> {{ $partnerGroup->province->name }}
                    </div>
                    <div class="col-3">
                        <strong>شهر:</strong> {{ $partnerGroup->city->name }}
                    </div>
                    <div class="col-3">
                        <strong>کارشناس شهر:</strong> {{ $partnerGroup->city->user->name }}
                    </div>
                    <div class="col-3">
                        <strong>وضعیت سفارش:</strong>
                        
                        @include('partner::management.includes.statuses', ['status' => $partnerGroup->status])
                        @if ($partnerGroup->city->user_id == auth('user')->user()?->id)
                            @include('core::includes.edit-modal-button', [
                                'target' => '#editStatusModal-' . $partnerGroup->id,
                            ])
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>توضیحات کارشناس:</strong> {{ $partnerGroup->status_description ?? '-' }} 
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <h3 class="text-muted">اطلاعات متقاضی:</h3>
                <div class="row mb-3">
                    <div class="col-3">
                        <strong>نام و نام خانوادگی:</strong> {{ $partnerGroup->partners[0]->name }}
                    </div>
                    <div class="col-3">
                        <strong>جنسیت:</strong> {{ config('partner.gender.' . $partnerGroup->partners[0]->gender)  }}
                    </div>
                    <div class="col-3">
                        <strong>کد ملی:</strong> {{ $partnerGroup->partners[0]->national_code }}
                    </div>
                    <div class="col-3">
                        <strong>تاریخ تولد:</strong> {{ verta($partnerGroup->partners[0]->birth_date)->format('Y/m/d') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <strong>شماره همراه:</strong> {{ $partnerGroup->partners[0]->phone }}
                    </div>
                    <div class="col-3">
                        <strong>شغل:</strong> {{ $partnerGroup->partners[0]->job }}
                    </div>
                    <div class="col-3">
                        <strong>تحصیلات:</strong> {{ config('partner.educations.' . $partnerGroup->partners[0]->education) }}
                    </div>
                    <div class="col-3">
                        <strong>آدرس:</strong> {{ $partnerGroup->partners[0]->address }}
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <h3 class="text-muted">اطلاعات همسر:</h3>
                <div class="row mb-3">
                    <div class="col-3">
                        <strong>نام و نام خانوادگی:</strong> {{ $partnerGroup->partners[1]->name }}
                    </div>
                    <div class="col-3">
                        <strong>جنسیت:</strong> {{ config('partner.gender.' . $partnerGroup->partners[1]->gender)  }}
                    </div>
                    <div class="col-3">
                        <strong>کد ملی:</strong> {{ $partnerGroup->partners[1]->national_code }}
                    </div>
                    <div class="col-3">
                        <strong>تاریخ تولد:</strong> {{ verta($partnerGroup->partners[1]->birth_date)->format('Y/m/d') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <strong>شماره همراه:</strong> {{ $partnerGroup->partners[1]->phone }}
                    </div>
                    <div class="col-3">
                        <strong>شغل:</strong> {{ $partnerGroup->partners[1]->job }}
                    </div>
                    <div class="col-3">
                        <strong>تحصیلات:</strong> {{ config('partner.educations.' . $partnerGroup->partners[1]->education) }}
                    </div>
                    <div class="col-3">
                        <strong>آدرس:</strong> {{ $partnerGroup->partners[1]->address }}
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <h3 class="text-muted">اطلاعات ازدواج:</h3>
                <div class="row mb-3">
                    <div class="col-3">
                        <strong>شماره عقدنامه:</strong> {{ $partnerGroup->marriage_certificate_no }}
                    </div>
                    <div class="col-3">
                        <strong>تاریخ عقد:</strong> {{ verta($partnerGroup->marriage_date)->format('Y/m/d')}}
                    </div>
                    <div class="col-3">
                        <strong>مکان ازدواج:</strong> {{ $partnerGroup->partners[1]->marriage_location ?? '-' }}
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12">
                        <strong>یادداشت:</strong> {{ $partnerGroup->notes ?? '-' }} 
                    </div>
                </div>
            </div>
            <div class="container d-flex mt-5">
                <h3 class="text-muted">تجهیزات مورد نیاز:</h3>
                <strong class="mt-1 mr-2">
                    @foreach ($partnerGroup->equipments as $key => $equipment)
                        {{$equipment->name}}
                        @if($key < $partnerGroup->equipments->count() - 1),@endif
                    @endforeach
                </strong>
            </div>
        </x-slot>
    </x-card>
    <x-card>
        <x-slot name="cardTitle">یادداشت ها</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row d-flex justify-content-center">
                <x-table-component>
                    <x-slot name="tableTh">
                        <tr class="bg-gray">
                            @php($tableTh = ['ردیف','توضیحات','تاریخ'])
                            @foreach ($tableTh as $th)
                                <th class="text-light">{{ $th }}</th>
                            @endforeach
                        </tr>
                    </x-slot>
                    <x-slot name="tableTd">
                        @forelse($notes as $note)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $note->description }}</td>
                                <td>{{ verta($note->created_at)->format('Y/m/d H:i') }}</td>
                            </tr> 
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">داده‌ای یافت نشد.</td>
                            </tr>
                        @endforelse
                    </x-slot>
                </x-table-component>
            </div>
        </x-slot>
    </x-card>
    @include('partner::management.includes.create-note-modal')
    @include('partner::management.includes.edit-modal')
@endsection
