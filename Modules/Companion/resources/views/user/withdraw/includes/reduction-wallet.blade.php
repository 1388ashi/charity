<x-modal id="reductionWallet" size="md">
    <x-slot name="title">کاهش کیف پول همیار</x-slot>
    <x-slot name="body">
        <form action="{{ route('user.withdraws.change-balance-wallet') }}" method="POST" class="save">
            @csrf
            <input type="hidden" name="type" value="reduction">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select id="companionReduction" name="companion_id" class="form-control select2">
                            <option value="" disabled selected>-- همیار را انتخاب کنید --</option>
                            @foreach ($companions as $companion)
                                <option value="{{ $companion->id }}" {{ old('companion_id') == $companion->id ? 'selected' : null }}>{{ $companion->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" name="amount" class="form-control comma" placeholder="مبلغ مورد نظر خود را انتخاب کنید" value="{{ old('amount') }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-danger" type="submit">کاهش</button>
                <button class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
            </div>
        </form>
    </x-slot>
</x-modal>