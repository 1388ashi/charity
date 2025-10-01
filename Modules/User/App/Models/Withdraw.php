<?php

namespace Modules\User\App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Bavix\Wallet\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Companion\App\Models\Companion;
use Modules\Core\Helpers\Helpers;
use Modules\Exhibitor\App\Models\Exhibitor;
use Modules\User\App\Models\BankAccount;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Withdraw extends Model implements ProductInterface
{
    use HasWallet, LogsActivity;

    public static $commonRelations = [
        'transactions'
    ];

    protected $fillable = [
        'amount',
        // 'bank_account_id',
        'status',   
        'tracking_code'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELED = 'canceled';

    public static function getStatusTranslation($status)
    {
        $trans = [
            static::STATUS_PENDING => 'در انتظار تکمیل',
            static::STATUS_PAID => 'پرداخت شده',
            static::STATUS_CANCELED => 'لغو شده'
        ];

        return $trans[$status] ?? 'نامعلوم';
    }

    public static function booted()
    {
        static::updating(function (Withdraw $withdraw) {
            if ($withdraw->isDirty('status')) {
                $oldStatus = $withdraw->getOriginal('status');
                $newStatus = $withdraw->status;
                if (static::isSuccessStatus($oldStatus) && static::isFailedStatus($newStatus)) {
                    /** @var Customer $customer */
                    $customer = $withdraw->customer;
                    $customer->refund($withdraw);
                } else if (static::isFailedStatus($oldStatus) && static::isSuccessStatus($newStatus)) {
                    /** @var Customer $customer */
                    $customer = $withdraw->customer;
                    $customer->pay($withdraw);
                }
            }
        });
    }
    public function scopeUserFilters($query)
    {
        return $query
            ->when(request('companion_id'), function ($q) {
                    $q->whereRelation('companion','id', request('companion_id'));
            })
            ->when(request('start_date'), function ($q) {
                $q->whereDate('created_at', '>=', request('start_date'));
            })
            ->when(request('end_date'), function ($q) {
                $q->whereDate('created_at', '<=', request('end_date'));
            });
    }
    public static function getAvailableStatuses(): array
    {
        return [
          static::STATUS_PENDING, static::STATUS_PAID,
          static::STATUS_CANCELED
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        if (app()->runningInConsole()){
            return LogOptions::defaults()->submitEmptyLogs();
        }
        $admin = Auth::user();
        $name = !is_null($admin->name) ? $admin->name : $admin->username;
        return LogOptions::defaults()
            ->useLogName('Withdraw')->logAll()->logOnlyDirty()
            ->setDescriptionForEvent(function($eventName) use ($name){
                $eventName = Helpers::setEventNameForLog($eventName);
                return "دسته بندی {$this->title} توسط ادمین {$name} {$eventName} شد";
            });
    }

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }

    public function isCancelableByCustomer()
    {
        return !in_array($this->status, [
            static::STATUS_PAID,
            static::STATUS_CANCELED
        ]);
    }

    public static function isSuccessStatus($status): bool
    {
        return in_array($status, [
            static::STATUS_PENDING, static::STATUS_PAID
        ]);
    }

    public static function isFailedStatus($status): bool
    {
        return in_array($status, [
            static::STATUS_CANCELED
        ]);
    }

    public static function store(Companion $companion, Request $request)
    {
        $withdraw = new static($request->all());
        $withdraw->status = static::STATUS_PENDING;
        // $withdraw->bank_account_id  = $request->bank_account_id; 
        $withdraw->companion()->associate($companion);
        $withdraw->save();

        return $withdraw;
    }

    public function canBuy(\Bavix\Wallet\Interfaces\Customer $customer, int $quantity = 1, bool $force = false): bool
    {
        return true;
    }

    public function companion(): BelongsTo  
    {
        return $this->belongsTo(Companion::class);
    }
    // public function bankAccount(): BelongsTo  
    // {
    //     return $this->belongsTo(BankAccount::class);
    // }

    public function getMetaProduct(): ?array
    {
        return [
          'description' => 'برداشت از کیف پول با شناسه #' . $this->id . ' با وضعیت ' . static::getStatusTranslation($this->status)
        ];
    }

    public function getAmountProduct(Customer $customer): int|string
    {
        return $this->amount;
    }
}
