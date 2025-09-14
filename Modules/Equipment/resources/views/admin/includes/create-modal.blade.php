<x-modal id="createEquipmentModal" size="md">
    <x-slot name="title">ثبت تجهیزات جدید</x-slot>
    <x-slot name="body">
    <form action="{{ route('admin.equipments.store') }}" method="POST" class="save">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="نام">
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button class="btn btn-primary" type="submit">ثبت و ذخیره</button>
            <button class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
        </div>
    </form>
    </x-slot>
</x-modal>