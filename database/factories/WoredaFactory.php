<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Woreda>
 */
class WoredaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->countryCode(),
            'qoutaInpercent' => 0.25,
            'zone_id' => $this->faker->unique(true)->numberBetween(1,Zone::count()),
        ];
    }
}
