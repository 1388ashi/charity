@foreach ($withdraws as $withdraw)
<x-modal id="show-withdraw-modal-{{ $withdraw->id }}" size="lg">
  <x-slot name="title">ثبت درخواست جدید</x-slot>
  <x-slot name="body">
    <form action="{{ route('exhibitor.withdraws.store') }}" method="POST" class="save" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col">
          <ul>
              <li><strong>مبلغ(تومان): </strong> {{ number_format($withdraw->amount) }}</li>
          </ul>
        </div>
        <div class="col">
          <ul>
              <li><strong>وضعیت: </strong> @include('order::admin.withdraw.includes.status', ['status' => $withdraw->status])</li>
          </ul>
        </div>
      </div>
      <br>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-primary" type="submit">ثبت و ذخیره</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">انصراف</button>
      </div>
    </form>
  </x-slot>
</x-modal>
@endforeach