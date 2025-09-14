<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Partner\Database\Factories\NoteFactory;

class Note extends Model
{
    protected $fillable = [
        'partner_group_id',
        'user_id',
        'description',
    ];

    public function partnerGroup()
    {
        return $this->belongsTo(PartnerGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
