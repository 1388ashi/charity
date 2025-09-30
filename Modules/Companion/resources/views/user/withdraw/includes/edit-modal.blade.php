@foreach ($withdraws as $withdraw)
<x-modal id="editStatusModal-{{ $withdraw->id }}" size="md">
    <x-slot name="title">ویرایش وضعیت - کد {{ $withdraw->id }}</x-slot>
    <x-slot name="body">
        <form action="{{ route('admin.withdraws.edit-status', $withdraw) }}" method="POST" class="save">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="status" class="form-control select2" required>
                            <option value="pending" @selected($withdraw->status == 'pending')>در حال بررسی</option>
                            <option value="approved" @selected($withdraw->status == 'approved')>پرداخت شده</option>
                            <option value="rejected" @selected($withdraw->status == 'rejected')>رد شده</option>
                        </select>
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