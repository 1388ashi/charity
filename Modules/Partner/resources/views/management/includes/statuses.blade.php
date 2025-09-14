 @if($partnerGroup->status == 'new')
    <span class="badge badge-info">جدید</span>
@elseif($partnerGroup->status == 'pending')
    <span class="badge badge-light">در حال بررسی</span>
@elseif($partnerGroup->status == 'await_payment')
    <span class="badge badge-warning">در انتظار پرداخت</span>
@elseif($partnerGroup->status == 'paid')
    <span class="badge badge-success">پرداخت شده</span>
@else
    <span class="badge badge-danger">رد شده</span>
@endif