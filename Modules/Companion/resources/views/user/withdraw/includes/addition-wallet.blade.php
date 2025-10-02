<x-modal id="additionWallet" size="md">
    <x-slot name="title">افزایش کیف پول همیار</x-slot>
    <x-slot name="body">
        <form action="{{ route('user.withdraws.change-balance-wallet') }}" method="POST" class="save">
            @csrf
            <input type="hidden" name="type" value="addition">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select id="companionAddition" name="companion_id" class="form-control select2">
                            <option value="" disabled selected>-- همیار را انتخاب کنید --</option>
                            @foreach ($companions as $companion)
                                <option value="{{ $companion->id }}" {{ old('companion_id') == $companion->id ? 'selected' : null }}>{{ $companion->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" name="amount" class="form-control comma" placeholder="مبلغ مورد نظر خود را به تومان وارد کنید" value="{{ old('amount') }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-success" type="submit">افزایش</button>
                <button class="btn btn-outline-info" data-dismiss="modal">انصراف</button>
            </div>
        </form>
    </x-slot>
</x-modal>