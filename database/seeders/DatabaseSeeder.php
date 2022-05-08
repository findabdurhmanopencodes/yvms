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
        Role::create(['name'=>'applicant']);
        // \App\Models\User::factory(10)->create();
        $this->call([
            TrainingSessionSeeder::class,
            VolunteerSeeder::class,
            RegionSeeder::class,
            ZoneSeeder::class,
            WoredaSeeder::class,
            EducationalLevelSeeder::class,
            FeildOfStudySeeder::class,
            TraininingCenterSeeder::class
        ]);
    }
}
