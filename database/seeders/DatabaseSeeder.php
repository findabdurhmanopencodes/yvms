<?php

namespace Database\Seeders;

use App\Models\ApprovedApplicant;
use App\Models\EducationalLevel;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Woreda;
use App\Models\Zone;
use Database\Factories\UserFactory;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
            PermissionSeeder::class,
            RoleSeeder::class,
            // BaseSeeder::class,
        //     // FakeDataSeeder::class,
        ]);

        User::create(
            [
                'first_name' => 'Super',
                'father_name' => 'Admin',
                'grand_father_name' => 'Mop',
                'dob' => '1999-04-28',
                'gender' => 'M',
                'email' => 'super@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => Str::random(10),
            ]
        );


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
        $quota = [0.4, 0.3, 0.3];
        $region = 1;
        for ($y = 0; $y < 3; $y++) {
            \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        }
        $quota = [0.3, 0.2, 0.1, 0.2, 0.2];
        $region = 2;
        for ($y = 0; $y < count($quota); $y++) {
            \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        }
        $quota = [0.5, 0.2, 0.1, 0.2];
        $region = 3;
        for ($y = 0; $y < count($quota); $y++) {
            \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        }
        $quota = [0.1, 0.3, 0.6];
        $region = 4;
        for ($y = 0; $y < count($quota); $y++) {
            \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        }
        //Woreda creation
        $zonesCount = Zone::count();
        $quotas = [
            [0.2, 0.4, 0.4],
            [0.2, 0.5, 0.1, 0.2],
            [0.2, 0.2, 0.1, 0.3, 0.2]
        ];
        $zone = 1;
        $iterate = 0;
        for ($x = 0; $x < $zonesCount; $x++) {
            $quota = $quotas[$iterate];
            for ($y = 0; $y < count($quota); $y++) {
                \App\Models\Woreda::factory(1)->create(['zone_id' => $zone, 'qoutaInpercent' => $quota[$y]]);
            }
            $zone++;
            $iterate++;
            if ($iterate > 2) {
                $iterate = 0;
            }
        }
        \App\Models\User::factory(200)->create();
        \App\Models\File::factory(16)->create();
        \App\Models\FeildOfStudy::factory(4)->create();
        $zones = Zone::all();
        foreach ($zones as $zone) {
            \App\Models\TraininingCenter::factory(1)->create(['zone_id' => $zone->id]);
        }

        $capacities = [6, 6, 5, 6, 7, 5, 6, 10, 7, 6, 4, 8, 7, 9, 8];
        $trainingcenters = TraininingCenter::all();
        foreach ($trainingcenters as $key => $center) {
            $data = ['capacity' => $capacities[$key], 'trainining_center_id' => $center->id];
            \App\Models\TrainingCenterCapacity::factory(1)->create($data);
        }
        $regions = Region::all();
        $totalPersons = 100;
        foreach ($regions as $region) {
            $regionQuota = $region->qoutaInpercent * 100;
            $zones = $region->zones;
            foreach ($zones as $zone) {
                $zoneQuota = $zone->qoutaInpercent * $regionQuota;
                $woredas = $zone->woredas;
                $woredaCount = 0;
                foreach ($woredas as  $woreda) {
                    $woredaQuota = round($woreda->qoutaInpercent * $zoneQuota);
                    for ($x = 0; $x < $woredaQuota; $x++)
                        \App\Models\Volunteer::factory(1)->create(['woreda_id' => $woreda->id]);
                }
            }
        }

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

        $this->approveAllVolunteers();
    }
    public function approveAllVolunteers()
    {
        foreach (Volunteer::all() as $v)
            ApprovedApplicant::create(['training_session_id' => 1, 'volunteer_id' => $v->id, 'status' => 1]);
    }
}
