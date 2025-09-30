@extends('layouts.user.master')

@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'برداشت های کیف پول']]" />
    </div>

    {{-- <form method="get" id='basicSearch' action="{{route('admin.admins.index')}}"
          autocomplete="off"
          onblur="document.form1.input.value = this.value;">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12" >
                <div class="card">
                    <div class="card-header  border-0">
                        <div class="card-title" data-toggle="card-collapse" style="font-size: 16px;font-weight: bold;">جستجوی پیشرفته</div>
                        <div class="card-options">
                            <a href="#" class="card-options-collapse" data-toggle="card-collapse" style="margin: 5px;"><i
                                    class="fe fe-chevron-up"></i></a>
                            <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen" style="margin: 5px;"><i
                                    class="fe fe-maximize"></i></a>
                            <a href="#" class="card-options-remove" data-toggle="card-remove" style="margin: 5px;"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name">نام و نام خانوادگی</label>
                                            <input type="text" name="name" class="form-control"
                                                   placeholder="نام و نام خانوادگی" id="name" value="{{ request('name') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="mobile">تلفن همراه</label>
                                            <input type="text" name="mobile" value="{{ request('mobile') }}"
                                                   class="form-control"
                                                   id="mobile" placeholder="تلفن همراه">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="status">وضعیت</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">همه وضعیت ها</option>
                                                <option value="1">فعال</option>
                                                <option value="0">غیرفعال</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-2 pt-5">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">جستجو</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> --}}


    <x-card>
        <x-slot name="cardTitle">لیست همه برداشت های کیف پول ({{ $withdraws->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        <th>ردیف</th>
                        <th>شناسه</th>
                        <th>غرفه</th>
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