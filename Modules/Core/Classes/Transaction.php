<?php


namespace Modules\Core\Classes;


use Bavix\Wallet\Models\Transfer;
use Modules\User\App\Models\Deposit;

class Transaction extends \Bavix\Wallet\Models\Transaction
{
    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'withdraw_id');
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class);
    }
}
