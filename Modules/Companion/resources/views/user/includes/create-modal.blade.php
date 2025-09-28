<x-modal id="createCompanionModal" size="md">
    <x-slot name="title">ثبت همیار جدید</x-slot>
    <x-slot name="body">
    <form action="{{ route('user.companions.store') }}" method="POST" class="save">
        @csrf
        <input type="hidden" name="city_id" value="{{ $city->id }}">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="نام و نام خانوادگی">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control" name="national_code" required value="{{ old('national_code') }}" placeholder="کد ملی">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control" name="mobile" required value="{{ old('mobile') }}" placeholder="شماره موبایل">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <select name="salary_type" class="form-control" id="salary_type" required>
                        <option value="" selected disabled>نوع قرار را انتخاب کنید</option>
                        <option value="fixed" {{ old('salary_type') == 'fixed' ? 'selected' : '' }}>ثابت</option>
                        <option value="percentage" {{ old('salary_type') == 'percentage' ? 'selected' : '' }}>درصد</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control comma" name="salary" required value="{{ old('salary') }}"
                        placeholder="مبلغ را به تومن یا درصد قرار داد را وارد کنید">
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