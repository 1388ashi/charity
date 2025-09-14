@if($order->status == 'wait_for_payment')
<span title="وضعیت" class="badge badge-warning ">در انتظار پرداخت</span>
@elseif($order->status == 'new')
<span title="وضعیت" class="badge badge-primary ">در انتظار تکمیل</span>
@elseif($order->status == 'in_progress')
<span title="وضعیت" class="badge badge-secondary  ">در حال پردازش</span>
@elseif($order->status == 'delivered')
<span title="وضعیت" class="badge badge-success ">ارسال شده</span>
@elseif($order->status == 'canceled')
<span title="وضعیت" class="badge badge-danger ">کنسل شده</span>
@elseif($order->status == 'failed')
<span title="وضعیت" class="badge badge-danger ">خطا</span>
@elseif($order->status == 'wait_for_accounting')
<span title="وضعیت" class="badge badge-info ">در انتظار تایید حسابدار</span>
@else
<span title="وضعیت" class="badge badge-danger ">کنسل شده توسط کاربر</span>
@endif
  