@if($withdraw->status == 'pending')
    <span title="وضعیت" class="badge badge-info ">در حال بررسی</span>
@elseif($withdraw->status == 'approved')
    <span title="وضعیت" class="badge badge-success ">پرداخت شده</span>
@else
    <span title="وضعیت" class="badge badge-danger">رد شده</span>
@endif
