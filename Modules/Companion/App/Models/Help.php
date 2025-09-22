<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Companion\Models\helpUser;
use Modules\Equipment\App\Models\Equipment;
use Modules\Invoice\Classes\Payable;

// use Modules\Companion\Database\Factories\HelpFactory;

class Help extends Payable
{
    protected $fillable = ['companion_id','help_user_id','type','status_payment','amount'];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class)->withPivot('quantity');
    }
    public function helpUser()
    {
        return $this->belongsTo(HelpUser::class,'help_user_id');
    }
    public function isPayable()
    {
        return $this->status == 0;
    }

    public function getPayableAmount()
    {
        return $this->amount;
    }
     public function callBackViewPayment($invoice): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('core::invoice.callback',
            [
                'invoice' => $invoice,
                'type' => 'order'
            ]
        );
    }

    public function onSuccessPayment(\Modules\Invoice\App\Models\Invoice $invoice)
    {
         $this->update([
            'status_payment' => 1,
        ]);
        //send sms to user
        return $this->callBackViewPayment($invoice);
    }
}
