<?php

namespace Database\Factories;

use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LicenseFactory extends Factory
{
    protected $model = License::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => app('hash')->make("password"),
            'machine_code' => $this->faker->md5,
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'license_type' => $this->faker->randomElement(['demo', 'registered']),
            'status' => $this->faker->randomElement([1, 0])
        ];
    }
}
