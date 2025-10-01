@extends('layouts.user.master')

@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'برداشت های کیف پول']]" />
    </div>

  <x-card>
        <x-slot name="cardTitle">جستجوی پیشرفته</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <div class="row">
                <form action="{{ route('user.withdraws.index') }}" method="GET" class="col-12">
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
                            <a href="{{ route('user.withdraws.index') }}" class="btn btn-danger btn-sm btn-block">حذف همه فیلتر ها
                                <i class="fa fa-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-card>    

    <x-card>
        <x-slot name="cardTitle">لیست همه برداشت های کیف پول ({{ $withdraws->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        <th>ردیف</th>
                        <th>شناسه</th>
                        <th>همیار</th>
                        <th>مبلغ(تومان)</th>
                        {{-- <th>شماره کارت</th> --}}
                        <th>وضعیت</th>
                        <th>تاریخ ثبت</th>
                        <th>عملیات</th>
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse($withdraws as $withdraw)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $withdraw->id }}</td>
                            <td>{{ $withdraw->companion->name . ' ' . '-' . ' ' . $withdraw->companion->mobile }}</td>
                            <td>{{ number_format($withdraw->amount) }}</td>
                            {{-- <td>{{ $withdraw->bankAccount->cart_number }}</td> --}}
                            <td>@include('companion::user.withdraw.includes.status', ['status' => $withdraw->status])</td>
                            <td>{{ verta($withdraw->created_at)->format('Y/m/d H:i') }}</td>
                            <td> 
                                @include('core::includes.edit-modal-button', [
                                    'target' => '#editStatusModal-' . $withdraw->id,
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 7])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">
                    {{ $withdraws->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}
                </x-slot>
            </x-table-component>
        </x-slot>
    </x-card>
     @include('companion::user.withdraw.includes.edit-modal')
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
         $(document).ready(function() {
            $('#companionId').select2({
                placeholder: "-- انتخاب همیار --",
                allowClear: true
            });
        });
    </script>
@endsection