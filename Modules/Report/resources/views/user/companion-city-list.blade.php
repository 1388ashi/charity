@extends('layouts.user.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'گزارش همیاران']]" />
    </div>

    <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('user.reports.companions-filter-by-city',$city->id) }}" method="GET" class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select id="companionId" name="companion_id" class="form-control select2">
                                    <option value="" disabled selected>-- همیار را انتخاب کنید --</option>
                                    @foreach ($companions as $companion)
                                    <option value="{{ $companion->id }}" {{ request('companion_id') == $companion->id ? 'selected' : null }}>{{ $companion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input class="form-control fc-datepicker" id="start_date_show" type="text"
                                    autocomplete="off" placeholder="از تاریخ" />
                                <input name="start_date" id="start_date_hide" type="hidden"
                                    value="{{ request('start_date') }}" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input class="form-control fc-datepicker" id="end_date_show" type="text"
                                    autocomplete="off" placeholder="تا تاریخ" />
                                <input name="end_date" id="end_date_hide" type="hidden"
                                    value="{{ request('end_date') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-6 col-12">
                            <button class="btn btn-primary btn-sm btn-block" type="submit">جستجو <i
                                    class="fa fa-search"></i></button>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <a href="{{ route('user.reports.companions-filter-by-city',$city->id) }}" class="btn btn-danger btn-sm btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">لیست کمک های شهر {{ $city->name }}</x-slot>
        {{-- //اسم کارشناس --}}
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="">
                <span>کارشناس شهر :</span>
                <span class="font-weight-bold">{{ $city->user->name }}</span>
            </div>
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف','همیار','کمک کننده','نوع کمک','تاریخ ثبت'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($helps as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $item->companion ? $item->companion->name . ' - ' . $item->companion->mobile : 'آزاد(بدون همیار)' }}</td>
                            <td>{{ $item->helpUser->name . ' - ' . $item->helpUser->mobile }}</td>
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
@section('scripts')
    @include('core::includes.date-input-script', [
        'dateInputId' => 'start_date_hide',
        'textInputId' => 'start_date_show',
    ])

    @include('core::includes.date-input-script', [
        'dateInputId' => 'end_date_hide',
        'textInputId' => 'end_date_show',
    ])
     <script>
        $('#companionId').select2({
            placeholder: 'انتخاب همیار'
        });
    </script>
@endsection