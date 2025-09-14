@foreach ($companions as $companion)
<x-modal id="editCompanionModal-{{ $companion->id }}" size="md">
    <x-slot name="title">ویرایش تجهیزات - کد {{ $companion->id }}</x-slot>
    <x-slot name="body">
        <form action="{{ route('user.companions.update', $companion) }}" method="POST" class="save">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" id="name" class="form-control" name="name" required 
                            value="{{ old('name', $companion->name) }}" placeholder="نام و نام خانوادگی">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" id="national_code" class="form-control" name="national_code" required 
                            value="{{ old('national_code', $companion->national_code) }}" placeholder="کد ملی">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" id="mobile" class="form-control" name="mobile" required 
                            value="{{ old('mobile', $companion->mobile) }}" placeholder="شماره موبایل">
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