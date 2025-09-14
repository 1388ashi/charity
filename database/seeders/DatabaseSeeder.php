<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Area\database\seeders\CitiesTableSeeder;
use Modules\Area\database\seeders\ProvincesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call(ProvincesTableSeeder::class);
       $this->call(CitiesTableSeeder::class);

    }
}
