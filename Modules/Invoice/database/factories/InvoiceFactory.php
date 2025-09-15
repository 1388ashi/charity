<?php

namespace Modules\Invoice\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Invoice\App\Models\Invoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

