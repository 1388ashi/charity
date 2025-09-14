<?php

namespace Modules\Partner\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Partner\Database\Factories\PartnerFactory;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_group_id ','gender','name','birth_date',
        'national_code','phone','email','address','job','education'
    ];
    const EDUCATION_CYCLE = 'cycle';
    const EDUCATION_DIPLOMA = 'diploma';
    const EDUCATION_ASSOCIATE = 'associate';
    const EDUCATION_BACHELOR = 'bachelor';
    const EDUCATION_MASTER = 'master';
    const EDUCATION_DOCTORATE = 'doctorate';
    public static $educations = [
        self::EDUCATION_CYCLE => 'سیکل',
        self::EDUCATION_DIPLOMA => 'دیپلم',
        self::EDUCATION_ASSOCIATE => 'فوق دیپلم',
        self::EDUCATION_BACHELOR => 'لیسانس',
        self::EDUCATION_MASTER => 'فوق لیسانس',
        self::EDUCATION_DOCTORATE => 'دکتری',
    ];
    public function group()
    {
        return $this->belongsTo(PartnerGroup::class, 'partner_group_id');
    }
}
