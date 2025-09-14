<x-modal id="editStatusModal-{{ $partnerGroup->id }}" size="md">
    <x-slot name="title">ویرایش وضعیت - کد {{ $partnerGroup->id }}</x-slot>
    <x-slot name="body">
        <form action="{{ route('user.management.partners.update-status', $partnerGroup) }}" method="POST" class="save">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="status" class="form-control select2" required>
                            @foreach (config('partner.statuses') as $name => $label)
                                <option value="{{ $name }}"
                                    {{ $partnerGroup->status == $name ? 'selected' : null }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="control-label">توضیحات</label>
                        <textarea name="status_description" class="form-control">{{ old("status_description",$partnerGroup->status_description) }}</textarea>
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