@foreach ($equipments as $equipment)
<x-modal id="editEquipmentModal-{{ $equipment->id }}" size="md">
    <x-slot name="title">ویرایش تجهیزات - کد {{ $equipment->id }}</x-slot>
    <x-slot name="body">
        <form action="{{ route('admin.equipments.update', $equipment) }}" method="POST" class="save">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" id="name" class="form-control" name="name" required value="{{ old('name', $equipment->name) }}" placeholder="نام">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-warning" type="submit">بروزرسانی</button>
                <button class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
            </div>
        </form>
    </x-slot>
</x-modal>
@endforeach