@extends('layouts.companion.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'کیف پول']]" />
        <x-create-button type="modal" target="withdraw-wallet-modal" title="درخواست برداشت" />
    </div>

    <x-card>
        <x-slot name="cardTitle">کیف پول</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <div class="row">
                <div class="col">
                    <ul>
                        <li><strong>موجودی کیف پول: </strong> {{ number_format($companion->wallet->balance) }}  تومان </li>
                        @if ($companion->salary_type == 'percentage' && $companion->salary)
                            <li class="mt-1"><strong>درصد شما از هر کمک: </strong> {{ number_format($companion->salary) }}% </li>
                        @endif
                    </ul>
                </div>
            </div>
        </x-slot>
    </x-card>
    <x-card>
        <x-slot name="cardTitle">درخواست های برداشت</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        <th>ردیف</th>
                        <th>شناسه</th>
                        <th>مبلغ(تومان)</th>
                        {{-- <th>شماره کارت</th> --}}
                        <th>وضعیت</th>
                        <th>تاریخ ثبت</th>
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse($withdraws as $withdraw)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $withdraw->id }}</td>
                            <td>{{ number_format($withdraw->amount) }}</td>
                            {{-- <td>{{ $withdraw->bankAccount->cart_number }}</td> --}}
                            <td>@include('companion::companion.wallet.includes.status', ['status' => $withdraw->status])</td>
                            <td>{{ verta($withdraw->created_at)->format('Y/m/d H:i') }}</td>
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
    @include('companion::companion.wallet.includes.create-modal')
@endsection