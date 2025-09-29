<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\CartInterface;
use Bavix\Wallet\Interfaces\ProductInterface;
use Bavix\Wallet\Models\Transfer;
use Bavix\Wallet\Interfaces\Customer as CustomerWallet;
use Modules\Area\App\Models\City;

class Companion extends Authenticatable implements CustomerWallet
{
    use HasWallet;
    protected $fillable = ['name','national_code','mobile','city_id','salary_type','salary'];
    
    public function isDeletable(): bool
    {
        return true;
    }
    protected static function booted()
    {
        static::created(function ($companion) {
            CompanionCode::create([
                'companion_id' => $companion->id,
                'code' => Str::random(10),
            ]);
            //TODO: send code to companion| generate url and code
        });
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function tokenCode()
    {
        return $this->hasOne(CompanionCode::class);
    }



      //start bavix/laravel-wallet
    public function safePay(ProductInterface $product, bool $force = false): ?Transfer
    {
        // TODO: Implement safePay() method.
    }

    public function payFree(ProductInterface $product): Transfer
    {
        // TODO: Implement payFree() method.
    }

    public function pay(ProductInterface $product, bool $force = false): Transfer
    {
        // TODO: Implement pay() method.
    }

    public function forcePay(ProductInterface $product): Transfer
    {
        // TODO: Implement forcePay() method.
    }

    public function safeRefund(ProductInterface $product, bool $force = false, bool $gifts = false): bool
    {
        // TODO: Implement safeRefund() method.
    }

    public function refund(ProductInterface $product, bool $force = false, bool $gifts = false): bool
    {
        // TODO: Implement refund() method.
    }

    public function forceRefund(ProductInterface $product, bool $gifts = false): bool
    {
        // TODO: Implement forceRefund() method.
    }

    public function safeRefundGift(ProductInterface $product, bool $force = false): bool
    {
        // TODO: Implement safeRefundGift() method.
    }

    public function refundGift(ProductInterface $product, bool $force = false): bool
    {
        // TODO: Implement refundGift() method.
    }

    public function forceRefundGift(ProductInterface $product): bool
    {
        // TODO: Implement forceRefundGift() method.
    }

    public function payFreeCart(CartInterface $cart): array
    {
        // TODO: Implement payFreeCart() method.
    }

    public function safePayCart(CartInterface $cart, bool $force = false): array
    {
        // TODO: Implement safePayCart() method.
    }

    public function payCart(CartInterface $cart, bool $force = false): array
    {
        // TODO: Implement payCart() method.
    }

    public function forcePayCart(CartInterface $cart): array
    {
        // TODO: Implement forcePayCart() method.
    }

    public function safeRefundCart(CartInterface $cart, bool $force = false, bool $gifts = false): bool
    {
        // TODO: Implement safeRefundCart() method.
    }

    public function refundCart(CartInterface $cart, bool $force = false, bool $gifts = false): bool
    {
        // TODO: Implement refundCart() method.
    }

    public function forceRefundCart(CartInterface $cart, bool $gifts = false): bool
    {
        // TODO: Implement forceRefundCart() method.
    }

    public function safeRefundGiftCart(CartInterface $cart, bool $force = false): bool
    {
        // TODO: Implement safeRefundGiftCart() method.
    }

    public function refundGiftCart(CartInterface $cart, bool $force = false): bool
    {
        // TODO: Implement refundGiftCart() method.
    }

    public function forceRefundGiftCart(CartInterface $cart): bool
    {
        // TODO: Implement forceRefundGiftCart() method.
    }

    public function paid(ProductInterface $product, bool $gifts = false): ?Transfer
    {
        // TODO: Implement paid() method.
    }
    //end bavix/laravel-wallet
}
