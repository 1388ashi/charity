@extends('layouts.help-user.master')
@section('content')
    <div class="page-header">
        <x-create-button route="help-user.help-page" :routeParams="['code' => $code]"  title="کمک جدید" />
    </div>
     <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">مجموع کمک های نقدی :</span>
                                        <p class="mb-0 mt-1 text-primary fs-20"> {{ number_format($totalAmountHelp) }} 
                                            @if($totalAmountHelp > 0)
                                                <span class="font-weight-bold fs-18">
                                                    تومن
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon1 bg-primary my-auto float-left">
                                        <i class="fa fa-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="mt-0 text-right">
                                        <span class="fs-16 font-weight-semibold">تعداد وسیله های اهدایی :</span>
                                        <p class="mb-0 mt-1 text-pink  fs-20">{{ $totalEquipmentHelp }}</p>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon1 bg-pink my-auto float-left">
                                        <i class="fa fa-shopping-bag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-card>
        <x-slot name="cardTitle">لیست کمک ها</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف','نوع کمک','تاریخ ثبت'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($helps as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->type == 'cash')
                                    نقدی ({{ number_format($item->amount) }} تومن)
                                @else
                                    تجهیزات: 
                                    <span class="font-weight-bold">
                                        @foreach ($item->equipments as $equipment)
                                            {{ $equipment->name }}
                                            @if($equipment->pivot->quantity > 1)
                                                ({{ $equipment->pivot->quantity }})
                                            @endif
                                            @if(!$loop->last), @endif
                                        @endforeach
                                    </span>
                                @endif
                            </td>
                            <td>{{ verta($item->created_at)->format('Y/m/d H:i') }}</td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 5])
                    @endforelse
                </x-slot>
            </x-table-component>
        </x-slot>
    </x-card>
@endsection
