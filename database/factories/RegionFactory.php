<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->firstName(),
            'code' => $this->faker->countryCode(),
            'qoutaInpercent' => $this->faker->unique()->randomElement([0.4,0.2,0.3,0.1]),
            'status'=>1
        ];
    }
}
