<?php

namespace Database\Factories;

use App\Models\FeildOfStudy;
use App\Models\File;
use App\Models\TrainingSession;
use App\Models\User;
use App\Models\Woreda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volunteer>
 */
class VolunteerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;
        $woredas = Woreda::pluck('id')->toArray();
        return [
            'first_name' => $faker->name('male'),
            'father_name' => $faker->name('male'),
            'grand_father_name' => $faker->name('male'),
            'email' => $faker->unique()->email(),
            'dob' => '1999-04-28',
            'gender' => 'M',
            'phone' => '0952655896',
            'contact_name' => $faker->name('male'),
            'contact_phone' => '0925369874',
            'gpa' => 2.5,
            'woreda_id' => $faker->randomElement($woredas),
            'photo' => $this->faker->numberBetween(1,File::count()),
            'bsc_document' => $this->faker->numberBetween(1,File::count()),
            'ministry_document' => $this->faker->numberBetween(1,File::count()),
            'ethical_license' => $this->faker->numberBetween(1,File::count()),
            'educational_level' => 0,
            'user_id' => $this->faker->unique()->numberBetween(1,User::count()),
            'training_session_id' => TrainingSession::first(),
            'field_of_study_id' => $this->faker->numberBetween(1,FeildOfStudy::count()),
        ];
    }
}
