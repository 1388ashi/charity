<x-modal id="withdraw-wallet-modal" size="lg">
  <x-slot name="title">ثبت درخواست جدید</x-slot>
  <x-slot name="body">
    <form action="{{ route('companion.withdraws.store') }}" method="POST" class="save" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-6">
          <div class="form-group">
            <label class="control-label">مبلغ (تومان):<span class="text-danger">&starf;</span></label>
            <input type="text" class="form-control comma" name="amount" required value="{{ old('amount') }}" placeholder="مبلغ برداشت">
          </div>
        </div>
        {{-- <div class="col-6">
          <div class="form-group">
            <label class="control-label">شماره کارت:<span class="text-danger">&starf;</span></label>
            <select name="bank_account_id" class="form-control select2" required>
              <option value="" disabled selected>-- کارت را انتخاب کنید --</option>
              @foreach ($bankAccounts as $bankAccount)
                  <option value="{{ $bankAccount->id }}">{{ $bankAccount->cart_number }}</option>
              @endforeach
            </select>
          </div>
        </div> --}}
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-primary" type="submit">ثبت و ذخیره</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
      </div>
    </form>
  </x-slot>
</x-modal>