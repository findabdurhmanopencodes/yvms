<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Woreda;
use Database\Factories\UserFactory;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $userData = (new  UserFactory())->definition();
        // $userData['email'] = "super@gmail.com";
        // User::create($userData);
        // TrainingSession::create([
        //     'start_date' => '2022-05-06',
        //     'end_date' => '2022-05-16',
        //     'moto' => 'We are in the community',
        //     'registration_start_date' => '2022-05-8',
        //     'registration_dead_line' => '2022-05-25',
        //     'quantity' => 2000,
        //     'status' => 0,
        // ]);
        // Role::create(['name'=>'applicant']);
        // \App\Models\User::factory(100)->create();
        // \App\Models\Region::factory(4)->create();
        // \App\Models\Zone::factory(4)->create();
        // \App\Models\Woreda::factory(16)->create();
        // \App\Models\File::factory(16)->create();
        // \App\Models\FeildOfStudy::factory(4)->create();
        // \App\Models\Volunteer::factory(50)->create();

        $this->call([
            // TrainingSessionSeeder::class,
            // VolunteerSeeder::class,
            // RegionSeeder::class,
            // ZoneSeeder::class,
            // WoredaSeeder::class,
            // EducationalLevelSeeder::class,
            // FeildOfStudySeeder::class,
            // TraininingCenterSeeder::class
        ]);
    }
}
