@extends('layouts.companion.master')
@section('content')

  <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('companion.help-user.index') }}" method="GET" class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="نام هامی" name="name" value="{{ old('name') }}"/>
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
                            <a href="{{ route('companion.help-user.index') }}" class="btn btn-danger btn-sm btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>

    <x-card>
        <x-slot name="cardTitle">لیست کمک ها</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'هامی','شماره تماس','نوع کمک','تاریخ ثبت'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($helps as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $item->helpUser->name }}</td>
                            <td>{{ $item->helpUser->mobile }}</td>
                            <td>
                                @if ($item->type == 'cash')
                                    نقدی ({{ number_format($item->amount) }} تومن)
                                @else
                                    تجهیزات: <span class="font-weight-bold">{{ $item->equipments->pluck('name')->join(', ') }}</span> 
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
@endsection