@extends('layouts.user.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست همیاران']]" />
        <x-create-button type="modal" target="createCompanionModal" title="همیار جدید" />
    </div>

    <x-card>
        <x-slot name="cardTitle">همیاران شهر {{ $city->name }} ({{ count($companions) }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام','موبایل','نوع قرارداد','تاریخ ثبت', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($companions as $companion)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $companion->name }}</td>
                            <td>{{ $companion->mobile }}</td>
                            <td>
                                {{ $companion->salary_type == 'fixed' ? 'ثابت' . ' - ' .  number_format($companion->salary) . ' تومن '  : 'درصد' . ' - ' . $companion->salary . '%' }}</td>
                            <td>{{ verta($companion->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.edit-modal-button', [
                                    'target' => '#editCompanionModal-' . $companion->id,
                                ])
                                @include('core::includes.delete-icon-button', [
                                    'model' => $companion,
                                    'route' => 'user.companions.destroy',
                                    'disabled' => !$companion->isDeletable(),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 6])
                    @endforelse
                </x-slot>
            </x-table-component>
        </x-slot>
    </x-card>

    @include('companion::user.includes.create-modal')
    @include('companion::user.includes.edit-modal')
@endsection
