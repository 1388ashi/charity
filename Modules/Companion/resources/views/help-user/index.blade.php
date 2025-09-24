@extends('layouts.help-user.master')
@section('content')
    <div class="page-header">
        <x-create-button route="help-user.help-page" :routeParams="['code' => $code]"  title="کمک جدید" />
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
                                    <label for="name" class="control-label">نام و نام خانوادگی <span class="text-danger">&starf;</span></label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control" id="name"
                                        placeholder="نام کامل خود را اینجا وارد کنید..." required autofocus>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="national_code" class="control-label">کد ملی <span class="text-danger">&starf;</span></label>
                                    <input type="text" name="national_code" value="{{ old('national_code', $user->national_code) }}"
                                        class="form-control" id="national_code"
                                        placeholder="کد ملی خود را اینجا وارد کنید..." required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4">
                                ثبت اطلاعات
                                <i class="fa fa-hand-o-up text-white mt-1 mr-1"></i>
                            </button>
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
                        @php($tableTh = ['ردیف', 'همیار مرتبط','نوع کمک','تاریخ ثبت'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($helps as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $item->companion ? $item->companion->name . '-' . $item->companion->mobile : 'آزاد' }}</td>
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
