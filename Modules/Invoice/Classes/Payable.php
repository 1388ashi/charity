<?php


namespace Modules\Invoice\Classes;


use Bavix\Wallet\Interfaces\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\App\Models\Invoice;
use Modules\Invoice\Services\InvoiceService;

//use Modules\Core\Entities\BaseModel;
//use Modules\Invoice\Entities\Invoice;
//use Modules\Invoice\Entities\Payment;
//use Modules\Invoice\Services\InvoiceService;

abstract class Payable extends Model
{
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'payable');
    }

    public function onSuccessPayment(Invoice $invoice)
    {
        // Implement model logic

        return response()->json([
            'success' => true,
            'message' => __('Payment made successfully'),
            'data' => [
                'invoice_id' => $invoice->id,
                'status' => 'paid',
            ],
        ]);
    }

    public function onFailedPayment(Invoice $invoice)
    {
        // Implement model logic

        return response()->json([
            'success' => false,
            'message' => __('Payment failed'),
            'data' => [
                'invoice_id' => $invoice->id,
                'status' => 'failed',
                // اطلاعات دلخواه دیگر مثل مبلغ، تاریخ، دلیل خطا و ...
            ],
        ]);
    }

    public function isPayableReason()
    {
        return __(':class_name by id :id cannot be paid',
            ['class_name' => class_basename($this), 'id' => $this->getKey()]);
    }

    public function pay(PayDriver $payDriver = null)
    {
        $invoiceService = new InvoiceService($this);

        return $invoiceService->pay($payDriver);
    }

    public function payWithWallet(Wallet $user, PayDriver $payDriver = null)
    {
        $invoiceService = new InvoiceService($this);

        return $invoiceService->payWithWallet($user ,$payDriver);
    }

    public function additionalDataOnPay()
    {
        return [];
    }

    // فقط تو ایندکس ادمین استفاده کردم
    public function getActivePaymentAttribute($order = null)
    {
        $order = $order ?? $this;
        $res = null;
        /** @var Collection $invoices */
        $invoices = $order->invoices;
        foreach ($invoices as $invoice) {
            $break = false;
            foreach ($invoice->payments as $payment) {
                if ($payment->status === Payment::STATUS_SUCCESS) {
                    $res = $payment;
                    $break = true;
                    break;
                }
            }
            if ($break) {
                break;
            }
        }
        return $res;
    }

    // فاکتور هایی که یا کلا با کیف پول پرداخت شدن یا بخشیشون از کیف پول پرداخت شده
    // فقط موفق ها
    public function getSuccessWalletInvoices()
    {
        $order = $this;
        $res = null;
        /** @var Collection $invoices */
        $invoices = $order->invoices;
        $final = [];
        foreach ($invoices as $invoice) {
            if ($invoice->status === Invoice::STATUS_SUCCESS
                && in_array($invoice->type, [Invoice::PAY_TYPE_BOTH, Invoice::PAY_TYPE_WALLET])) {
                $final[] = $invoice;
            }
        }
        return $final;
    }

    public abstract function isPayable();

    public abstract function getPayableAmount();
}
