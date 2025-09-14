<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Partner\App\Models\Note;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        return [
            'partner_group_id' => null, 
            'user_id' => null, 
            'description' => $this->faker->paragraph(),
        ];
    }
}
