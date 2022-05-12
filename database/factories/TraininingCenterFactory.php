<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TraininingCenter>
 */
class TraininingCenterFactory extends Factory
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
            'decription' => $this->faker->text(40),
            'zone_id' => 2,
            'code' => $this->faker->regexify('[A-Z]{2,4}')
        ];
    }
}
