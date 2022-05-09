<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\User;
use App\Models\Volunteer;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        $password = $faker->password(8);
        $file = File::create([
            'name' => 'abdi',
            'file_path' => null,
        ]);
        $userData = [
            'first_name' => $faker->name('male'),
            'father_name' => $faker->name('male'),
            'grand_father_name' => $faker->name('male'),
            'email' => $faker->email(),
            'dob' => '1999-04-28',
            'gender' => 'M',
            'password' => Hash::make($faker->password()),
        ];
        $user = User::create($userData);

        $volunteerData = [
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
            'photo' => $file->id,
            'bsc_document' => $file->id,
            'ministry_document'=> $file->id,
            'ethical_license' => $file->id,
            'educational_level' => 0,
            'user_id' => $user->id,
            'training_session_id' => TrainingSession::first(),
            'field_of_study_id' => 1,
            // 'woreda_id' =>
        ];
        /*
       $table->string('first_name');
            $table->foreignIdFor(File::class,'non_pregnant_validation_document')->nullable();
            $table->foreignId('woreda_id')->nullable()->constrained('woredas')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('disablity_id')->nullable()->constrained('disablities')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();


        */
        // Volunteer::create();
    }
}
