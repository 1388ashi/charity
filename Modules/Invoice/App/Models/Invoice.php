<?php

namespace Modules\Invoice\App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\ProductInterface;
use Bavix\Wallet\Models\Transfer;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\App\Models\Admin;
use Modules\Companion\App\Models\Help;
use Modules\Core\Helpers\Helpers;
use Modules\Invoice\Classes\Payable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\Invoice\Database\Factories\InvoiceFactory;

class Invoice extends Model implements ProductInterface
{
    use HasWallet, LogsActivity;

    protected $fillable = [
        'amount',
        'type',
        'transaction_id',
        'status',
        'status_detail',
        'wallet_amount'
    ];

    protected static $commonRelations = [
        'payable'
    ];

    protected $attributes = [
        'wallet_amount' => 0
    ];

    const PAY_TYPE_WALLET = 'wallet';
    const PAY_TYPE_GATEWAY = 'gateway';
    const PAY_TYPE_BOTH = 'both';

    const STATUS_PENDING = 'pending';
    const STATUS_FAILED = 'failed';
    const STATUS_SUCCESS = 'success';

    public static function booted()
    {
        static::creating(function ($invoice) {
            if ($invoice->wallet_amount === 0) {
                $invoice->type = static::PAY_TYPE_GATEWAY;
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        $admin = Auth::user() ?? Admin::query()->first();
        $name = !is_null($admin->name) ? $admin->name : $admin->username;
        return LogOptions::defaults()
            ->useLogName('Invoice')->logAll()->logOnlyDirty()
            ->setDescriptionForEvent(function($eventName) use ($name, $admin){
                $eventName = Helpers::setEventNameForLog($eventName);
                $causer = $admin instanceof Admin ? 'ادمین' : 'مشتری';

                return "فاکتور با شناسه {$this->id} توسط {$causer} {$name} {$eventName} شد";
            });
    }

    public static function getAvailablePayType(): array
    {
        return [static::PAY_TYPE_BOTH, static::PAY_TYPE_GATEWAY, static::PAY_TYPE_WALLET];
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isExpired()
    {
        return false;
    }

    public function scopePendingPaid($query)
    {
        $query->where('status', static::STATUS_PENDING);
    }

    public static function storeByWallet(Payable $payable, Transfer $transfer = null, $status = 'success'): \Shetabit\Shopit\Modules\Invoice\Entities\Invoice
    {
        $walletPayableAmount = static::getWalletPayableAmount($payable);
        $amount = $payable->getPayableAmount();

        $invoice = new static([
            'amount' => $amount,
            'wallet_amount' => $walletPayableAmount,
            'type' => static::getType($amount,$walletPayableAmount),
            'transaction_id' => $transfer?->id,
            'status' => $status
        ]);
        $invoice->payable()->associate($payable);
        $invoice->save();

        return $invoice;
    }

    public function getPayAmount()
    {
        return (int)$this->amount - $this->wallet_amount;
    }

    public static function getType($amount, $walletPayableAmount): string
    {
        if($amount == $walletPayableAmount){
            $type = static::PAY_TYPE_WALLET;
        }elseif ($walletPayableAmount == 0){
            $type = static::PAY_TYPE_GATEWAY;
        }else{
            $type = static::PAY_TYPE_BOTH;
        }

        return $type;
    }

    public static function getWalletPayableAmount($payable)
    {
        /** @var Help $payable */
        // $balance = $payable->user->balance;
        // if ($balance == 0){
            return 0;
        // }

        // if ($balance >= $payable->getPayableAmount()) {
        //     $payWalletAmount = $payable->getPayableAmount();
        // }else{
        //     $payWalletAmount = $balance;
        // }

        // return $payWalletAmount;
    }

    public function canBuy(Customer $customer, int $quantity = 1, bool $force = null): bool
    {
        return !$customer->paid($this);
    }

    public function getAmountProduct(Customer $customer): int|string
    {
        return $this->getTotalAmount();
    }

    public function getMetaProduct(): ?array
    {
        return [
            'customer_name' => $this->payable->customer->full_name,
            'customer_mobile' => $this->payable->customer->mobile,
            'description' => $this->payable->payDescription ?: 'خرید سفارش به شماره #' . $this->payable?->id
        ];
    }

    public function getUniqueId(): string
    {
        return (string) $this->getKey();
    }    use HasFactory;


    public function getTotalAmount()
    {
        $totalItemsAmount = $this->payable->activeItems
            ->reduce(function ($total, $item) {
                return $total + ($item->amount * $item->quantity);
            });
        if (!is_null($this->payable->reserved_id)){
            $amount = ($totalItemsAmount) - $this->payable->attributes['discount_amount'];
        }else{
            $amount = ($totalItemsAmount + $this->payable->attributes['shipping_amount']) - $this->payable->attributes['discount_amount'];
        }

        return $amount;
    }
}
