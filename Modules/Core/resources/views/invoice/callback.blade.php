@extends('core::invoice.layouts.callback-master')

@section('content')
    @php($_success = ($invoice->status == \Modules\Invoice\App\Models\Invoice::STATUS_SUCCESS))
    <div class="grid grid-cols-2">
        <div
            class="col-span-2 md:h-50 grid grid-rows-2 md:grid-rows-1 sm:grid-rows-1 lg:grid-rows-1 grid-flow-col bg-gray-100 p-2.5">
            <div class="mx-auto">
                @if($_success)
                    <img src="/assets/images/Green.png" alt="tick" class="h-24 md:max-h-24 sm:max-h-24 mx-auto">
                    <h1 class="font-bold iranssans-bold md:text-2xl sm:text-sm text-green-600 text-xs">پرداخت شما با
                        موفقیت انجام شد</h1>
                @else
                    <img src="/assets/images/cross-mark.png" alt="tick" class="h-24 md:max-h-24 sm:max-h-24 mx-auto">
                    <h1 class="text-red-600 font-bold iranssans-bold md:text-2xl sm:text-sm text-xs">پرداخت ناموفق</h1>
                @endif
            </div>
            <div class="border-gray-300 border-r-2 pr-2.5">
                <h1 class="gap-2.5 grid pt-2 @if($_success) text-green-600 @else text-red-600 @endif">
                    <span><span class="bold">شماره سفارش: </span>{{ $invoice->payable_id }}</span>
                    <span><span class="bold">تاریخ پرداخت:</span> {{ verta($invoice->created_at)->format('H:i:s Y/m/d')  }}</span>
                    <span><span class="bold">مبلغ پرداخت:</span> {{ number_format($invoice->amount) }} تومان</span>
                    <span><span class="bold">نام پذیرنده:</span> {{ \Modules\Setting\App\Models\Setting::getFromName('shop_name') }}</span>
                    <span><span class="bold">وضعیت سفارش:</span> {{ __('core::statuses.'.$invoice->status) }}</span>
                </h1>
            </div>
        </div>
        <div class="bg-gray-100 col-span-2 grid grid-flow-col grid-rows-1 mt-2.5 p-2.5 rounded-b-2xl">
            <div>
                @if($type != 'wallet')
                    @if($_success)
                        <p>
                            مشتری عزیز از خرید امروز شما متشکریم.
                            برای ارائه خدمات بهتر به شما بعد از دریافت محصول نظر خود را برای ما ارسال کنید
                        </p>
                    @else
                        <p>
                            مشتری عزیز پرداخت شما با شکست مواجه شد درصورت کسر مبلغ از حساب در 24 ساعت آینده مبلغ سفارش
                            به حساب شما واریز میشود
                        </p>
                        <div class="text-center">
                            <p style="color: #f89595">********</p>
                            <p class="poem">
                                <span>من پذیرفتم که سفارش افسانه است</span>
                                <span>من پذیرفتم شکست سفارش جانانه است</span>
                            </p>
                        </div>

                    @endif
                @endif
            </div>
            <div>

            </div>
        </div>
    </div>
@endsection
