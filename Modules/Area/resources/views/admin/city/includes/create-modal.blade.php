<x-modal id="createCityModal" size="md">
  <x-slot name="title">ثبت شهر جدید</x-slot>
  <x-slot name="body">
    <form action="{{ route('admin.cities.store') }}" method="POST" class="save">
      @csrf
      <div class="row">
        <input type="hidden" name="province_id" value="{{ $province->id }}">
        <div class="col-12">
          <div class="form-group">
            <input type="text" class="form-control" name="name" required value="{{ old('name') }}" placeholder="نام شهر">
          </div>
        </div>
        <div class="col-12">
          <div class="form-group">
            <select name="user_id" class="form-control select2" required>
                <option value="" disabled selected>-- کاربر را انتخاب کنید --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="col-12">
          <div class="form-group">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="status" value="1" {{ old('status', 1) == 1 ? 'checked' : null }}/>
              <span class="custom-control-label">وضعیت</span>
            </label>
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