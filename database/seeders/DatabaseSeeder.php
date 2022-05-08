<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use App\Models\TraininingCenter;
use App\Models\Woreda;
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
        // Role::create(['name'=>'applicant']);
        // \App\Models\User::factory(50)->create();
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
