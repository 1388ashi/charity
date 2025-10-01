@extends('layouts.companion.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'گزارش تراکنش های کیف پول']]" />
    </div>

    <x-card>
        <x-slot name="cardTitle">گزارش تراکنش های کیف پول</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نوع تراکنش','مبلغ(تومان)','توضیحات','تاریخ تراکنش'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($transactions as $item)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>
                                @if($item->type == 'deposit')
                                    <span title="نوع تراکنش" class="badge badge-success">افزایش</span>
                                @else
                                    <span title="نوع تراکنش" class="badge badge-danger">کاهش</span>
                                @endif

                            </td>
                            <td style="direction: ltr;">{{ number_format($item->amount) }}</td>
                            <td>{{ $item->meta ? $item->meta['description'] : '-' }}</td>
                            <td>{{ verta($item->created_at)->format('Y/m/d H:i') }}</td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 5])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">
                    {{ $transactions->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}
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