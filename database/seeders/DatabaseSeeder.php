<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        License::factory()
            ->count(50)
            ->create();
    }
}
