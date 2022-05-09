<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use App\Models\Region;
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
        $volunteerRole = Role::create(['name' => 'volunteer']);
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $userData = (new  UserFactory())->definition();
        $userData['email'] = "super@gmail.com";
        $user = User::create($userData);
        $user->assignRole($superAdminRole);
        TrainingSession::create([
            'start_date' => '2022-05-06',
            'end_date' => '2022-05-16',
            'moto' => 'We are in the community',
            'registration_start_date' => '2022-05-8',
            'registration_dead_line' => '2022-05-25',
            'quantity' => 2000,
            'status' => 0,
        ]);
        \App\Models\Region::factory(4)->create();
        //Zone creation
        $quota = [0.4,0.3,0.3];
        $region = 1;
        for($y = 0;$y<3;$y++){
            \App\Models\Zone::factory(1)->create(['region_id'=>$region,'qoutaInpercent' => $quota[$y]]);
        }
        $quota = [0.3,0.2,0.1,0.2,0.2];
        $region = 2;
        for($y = 0;$y<count($quota);$y++){
            \App\Models\Zone::factory(1)->create(['region_id'=>$region,'qoutaInpercent' => $quota[$y]]);
        }
        $quota = [0.5,0.2,0.1,0.2];
        $region = 3;
        for($y = 0;$y<count($quota);$y++){
            \App\Models\Zone::factory(1)->create(['region_id'=>$region,'qoutaInpercent' => $quota[$y]]);
        }
        $quota = [0.1,0.3,0.6];
        $region = 4;
        for($y = 0;$y<count($quota);$y++){
            \App\Models\Zone::factory(1)->create(['region_id'=>$region,'qoutaInpercent' => $quota[$y]]);
        }

        //Woreda creation
        $zonesCount = Zone::count();
        for ($x = 0; $x < $zonesCount; $x++) {
            $quota = [0.2, 0.4, 0.4];
            for ($y = 0; $y < count($quota); $y++) {
                \App\Models\Woreda::factory(1)->create(['zone_id' => $x, 'qoutaInpercent' => $quota[$y]]);
            }
            $quota = [0.2, 0.5, 0.1, 0.2];
            for ($y = 0; $y < count($quota); $y++) {
                \App\Models\Woreda::factory(1)->create(['zone_id' => $x, 'qoutaInpercent' => $quota[$y]]);
            }
            $quota = [0.2, 0.2, 0.1, 0.3, 0.2];
            for ($y = 0; $y < count($quota); $y++) {
                \App\Models\Woreda::factory(1)->create(['zone_id' => $x, 'qoutaInpercent' => $quota[$y]]);
            }
        }
        //User Factory
        // \App\Models\User::factory(100)->create();
        // \App\Models\File::factory(16)->create();
        // \App\Models\FeildOfStudy::factory(4)->create();
        $regions = Zone::all();
        foreach ($regions as $region) {
        }
        // \App\Models\Volunteer::factory(100)->create();

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
