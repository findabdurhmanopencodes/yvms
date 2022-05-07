<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use App\Models\TraininingCenter;
use App\Models\Woreda;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TrainingSessionSeeder::class,
            RegionSeeder::class,
            ZoneSeeder::class,
            WoredaSeeder::class,
            EducationalLevelSeeder::class,
            FeildOfStudySeeder::class,
            TraininingCenterSeeder::class
        ]);
    }
}
