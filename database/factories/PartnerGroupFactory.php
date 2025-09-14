<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Partner\App\Models\PartnerGroup;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PartnerGroupFactory extends Factory
{
    protected $model = PartnerGroup::class;

    public function definition()
    {
        return [
            'marriage_date' => $this->faker->date(),
            'marriage_location' => $this->faker->city(),
            'marriage_certificate_no' => $this->faker->bothify('ACD-#####'),
            'notes' => $this->faker->sentence(),
        ];
    }
}
