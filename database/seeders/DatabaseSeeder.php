<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Woreda;
use App\Models\Zone;
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
        $this->call([
            // PermissionSeeder::class,
            RoleSeeder::class,
            BaseSeeder::class,
            // FakeDataSeeder::class,
        ]);
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
