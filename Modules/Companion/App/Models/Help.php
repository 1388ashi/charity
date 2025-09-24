<?php

namespace Modules\Companion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Companion\App\Models\helpUser;
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
    public function companion()
    {
        return $this->belongsTo(Companion::class);
    }
    public function isPayable()
    {
        return $this->status == 0;
    }

    public function getPayableAmount()
    {
        return $this->amount;
    }
    public function scopeFilters($q){
       $name = request('name');

       return $q        
        ->when($name, function ($q) use($name) {
            $q->whereHas('helpUser',function ($q) use ($name) {
                    $q->where('name', 'like', '%' . $name . '%');
                });
        })
        ->when(request('start_date'), function ($q) {
            $q->whereDate('created_at', '>=', request('start_date'));
        })
        ->when(request('end_date'), function ($q) {
            $q->whereDate('created_at', '<=', request('end_date'));
        });
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
