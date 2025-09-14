<?php

use Modules\Partner\App\Models\Partner;
use Modules\Partner\App\Models\PartnerGroup;

$educationCycle = Partner::EDUCATION_CYCLE;
$educationDiploma = Partner::EDUCATION_DIPLOMA;
$educationAssociate = Partner::EDUCATION_ASSOCIATE;
$educationBachelor = Partner::EDUCATION_BACHELOR;
$educationMaster = Partner::EDUCATION_MASTER;
$educationDoctorate = Partner::EDUCATION_DOCTORATE;


$statusNew = PartnerGroup::STATUS_NEW;
$statusPending = PartnerGroup::STATUS_PENDING;
$statusAwaitPayment = PartnerGroup::STATUS_AWAIT_PAYMENT;
$statusPaid = PartnerGroup::STATUS_PAID;
$statusRejected = PartnerGroup::STATUS_REJECTED;

return [
    'name' => 'Partner',

    'gender' => [
        'male' => 'آقا',
        'female' => 'خانم',
    ],
    'statuses' => [
        $statusNew => 'جدید',
        $statusPending => 'در حال بررسی',
        $statusAwaitPayment => 'در انتظار پرداخت',
        $statusPaid => 'پرداخت شده',
        $statusRejected => 'رد شده',
    ],
    'educations' => [
        $educationCycle => 'سیکل',
        $educationDiploma => 'دیپلم',
        $educationAssociate => 'فوق دیپلم',
        $educationBachelor => 'لیسانس',
        $educationMaster => 'فوق لیسانس',
        $educationDoctorate => 'دکتری',
    ],
];