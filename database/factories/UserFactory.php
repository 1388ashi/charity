<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'mobile'     => $this->faker->unique()->regexify('09[0-3][0-9]{8}'),
            'birth_date' => $this->faker->date('Y-m-d', '2005-01-01'),
            'gender'     => $this->faker->randomElement(['male', 'female']),
            'email'      => $this->faker->unique()->safeEmail(),
            'status'     => $this->faker->boolean(),
        ];
    }
}
