<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'code' => $this->faker->countryCode(),
            'qoutaInpercent' => $this->faker->unique(true)->randomElement([0.4,0.3,0.3]),
            'region_id' => $this->faker->unique()->numberBetween(1,Region::count()),
            'status'=>1
        ];
    }
}
