<x-modal id="createNoteModal" size="md">
    <x-slot name="title">ثبت یادداشت</x-slot>
    <x-slot name="body">
        <form action="{{ route('user.partners.store-note', $partnerGroup) }}" method="POST" class="save">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="control-label">توضیحات:</label>
                        <textarea name="description" class="form-control" required>{{ old("description") }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-primary" type="submit">ثبت</button>
                <button class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
            </div>
        </form>
    </x-slot>
</x-modal>