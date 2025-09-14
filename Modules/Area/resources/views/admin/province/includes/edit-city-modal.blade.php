@foreach ($province->cities as $city)
<x-modal id="editCityModal-{{ $city->id }}" size="md">
  <x-slot name="title">ویرایش شهر - کد - {{ $city->id }}</x-slot>
  <x-slot name="body">
    <form action="{{ route('admin.cities.update', $city) }}" method="post" class="save">
      @csrf
      @method("PUT")
      <div class="row">
        <input type="hidden" name="province_id" value="{{ $province->id }}">
        <div class="col-12">
          <div class="form-group">
            <label>نام شهر :<span class="text-danger">&starf;</span></label>
            <input type="text" class="form-control" name="name" required value="{{ old('name', $city->name) }}">
          </div>
        </div>
        <div class="col-12">
					<div class="form-group">
						<label for="name">کاربر :<span class="text-danger">&starf;</span></label>
						<select name="user_id" class="form-control select2" required>
							<option value="" disabled selected>-- کاربر را انتخاب کنید --</option>
							@foreach ($users as $user)
								<option value="{{ $user->id }}"
										{{  $province->user_id == $user->id ? 'selected' : null }}>
									{{ $user->name }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
        <div class="col-12">
          <div class="form-group">
            <label class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="status" value="1" {{ old('status', $city->status) == 1 ? 'checked' : null }}/>
              <span class="custom-control-label">وضعیت</span>
            </label>
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