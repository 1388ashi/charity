<?php


namespace Modules\Invoice\App\Models;


use Illuminate\Database\Eloquent\Model;

class VirtualGateway extends Model
{
    protected $fillable = [
        'amount', 'callback', 'transaction_id'
    ];
}
