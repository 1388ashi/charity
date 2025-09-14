@extends('layouts.admin.master')
@section('content')
    <div class="page-header">
        <x-breadcrumb :items="[['title' => 'لیست تجهیزات']]" />
        <x-create-button type="modal" target="createEquipmentModal" title="تجهیزات جدید" />
    </div>

    <x-card>
        <x-slot name="cardTitle">تجهیزات ({{ $equipments->total() }})</x-slot>
        <x-slot name="cardOptions"><x-card-options /></x-slot>
        <x-slot name="cardBody">
            @include('components.errors')
            <x-table-component>
                <x-slot name="tableTh">
                    <tr>
                        @php($tableTh = ['ردیف', 'نام', 'تاریخ ثبت', 'عملیات'])
                        @foreach ($tableTh as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableTd">
                    @forelse ($equipments as $equipment)
                        <tr>
                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                            <td>{{ $equipment->name }}</td>
                            <td>{{ verta($equipment->created_at)->format('Y/m/d H:i') }}</td>
                            <td>
                                @include('core::includes.edit-modal-button', [
                                    'target' => '#editEquipmentModal-' . $equipment->id,
                                ])
                                @include('core::includes.delete-icon-button', [
                                    'model' => $equipment,
                                    'route' => 'admin.equipments.destroy',
                                    'disabled' => !$equipment->isDeletable(),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('core::includes.data-not-found-alert', ['colspan' => 4])
                    @endforelse
                </x-slot>
                <x-slot name="extraData">{{ $equipments->onEachSide(0)->links('vendor.pagination.bootstrap-4') }}</x-slot>
            </x-table-component>
        </x-slot>
    </x-card>

    @include('equipment::admin.includes.create-modal')
    @include('equipment::admin.includes.edit-modal')
@endsection
