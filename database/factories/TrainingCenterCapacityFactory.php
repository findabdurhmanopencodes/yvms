<?php

namespace Database\Factories;

use App\Models\TraininingCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingCenterCapacity>
 */
class TrainingCenterCapacityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'trainining_center_id' => 2,
            'training_session_id' => 1,
            'capacity' => 2,
        ];
    }
}
