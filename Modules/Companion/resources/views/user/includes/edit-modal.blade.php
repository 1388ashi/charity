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
                <div class="col-12">
                    <div class="form-group">
                        <select name="salary_type" class="form-control" id="salary_type" required>
                            <option value="" selected disabled>نوع قرار را انتخاب کنید</option>
                            <option value="fixed" {{ old('salary_type',$companion->salary_type) == 'fixed' ? 'selected' : '' }}>ثابت</option>
                            <option value="percentage" {{ old('salary_type',$companion->salary_type) == 'percentage' ? 'selected' : '' }}>درصد</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" class="form-control comma" name="salary" required value="{{ old('salary',number_format($companion->salary)) }}"
                            placeholder="مبلغ را به تومن یا درصد قرار داد را وارد کنید">
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