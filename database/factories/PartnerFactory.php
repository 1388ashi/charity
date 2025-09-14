<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Partner\App\Models\Partner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition()
    {
        return [
            'partner_group_id' => null,
            'gender' => $this->faker->randomElement(['male','female']),
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->date(),
            'national_id' => (string) $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'job' => $this->faker->jobTitle(),
            'education' => $this->faker->randomElement(['cycle','diploma','associate','bachelor','master','doctorate']),
        ];
    }
}
