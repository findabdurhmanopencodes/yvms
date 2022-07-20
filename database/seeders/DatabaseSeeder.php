<?php

namespace Database\Seeders;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\WoredaController;
use App\Http\Controllers\ZoneController;
use App\Models\ApprovedApplicant;
use App\Models\EducationalLevel;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Woreda;
use App\Models\WoredaIntake;
use App\Models\Zone;
use Database\Factories\UserFactory;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

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
            // RoleSeeder::class,
            // AbdiSeeder::class,
            // BaseSeeder::class,
            // FakeDataSeeder::class,
        ]);
        // dd('abdi for testing');
        $superUser = User::create(
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
        $superUser->assignRole('super-admin');
        // TrainingSession::create([
        //     'start_date' => '2022-05-06',
        //     'end_date' => '2022-07-07',
        //     'moto' => 'Kindness for living together',
        //     'registration_start_date' => '2022-05-01',
        //     'registration_dead_line' => '2022-06-29',
        //     'quantity' => 800,
        //     'status' => 0,
        // ]);

        // (new RegionController())->import();
        // (new ZoneController())->import();
        // (new WoredaController())->import();
        // \App\Models\File::factory(16)->create();
        // \App\Models\FeildOfStudy::factory(4)->create();

        // $quota = [0.3, 0.3, 0.4];
        // $capacities = [6, 6, 5, 6, 7, 5, 6, 10, 7, 6, 4, 8, 7, 9, 8];
        // foreach (Region::all()->take(3) as $key => $region) {
        //     $region->update(['qoutaInpercent' => $quota[$key], 'status' => 1]);
        //     $regionQuota = $region->qoutaInpercent * 200;
        //     foreach ($region->zones()->where('region_id', $region->id)->get()->take(3) as $key => $zone) {
        //         $center = \App\Models\TraininingCenter::factory(1)->create(['zone_id' => $zone->id]);
        //         $data = ['capacity' => 22, 'trainining_center_id' => $center[0]->id];
        //         \App\Models\TrainingCenterCapacity::factory(1)->create($data);
        //         $zone->update(['qoutaInpercent' => $quota[$key], 'status' => 1]);
        //         $zoneQuota = $zone->qoutaInpercent * $regionQuota;
        //         foreach ($zone->woredas()->where('zone_id', $zone->id)->get()->take(3) as $key => $wereda) {
        //             $wereda->update(['qoutaInpercent' => $quota[$key], 'status' => 1]);
        //             $woredaQuota = round($wereda->qoutaInpercent * $zoneQuota);
        //             $list = [];
        //             for ($x = 0; $x < $woredaQuota; $x++) {
        //                 $index = mt_rand(1, count(\App\FourthRoundAmhCSVInArrayFormat::AMH_LIST));
        //                 if (in_array($index, $list) || count(explode(' ', \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][1], 3)) < 2) {
        //                     $index = mt_rand(1, count(\App\FourthRoundAmhCSVInArrayFormat::AMH_LIST));
        //                 }
        //                 $list[] = $index;
        //                 $user = User::factory(1)->create();
        //                 \App\Models\Volunteer::factory(1)->create([
        //                     'woreda_id' => $wereda->id, 'user_id' => $user[0]->id,
        //                     'first_name' => strtoupper(explode(' ', \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][1], 3)[0]),
        //                     'father_name' => count(explode(' ', \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][1], 3)) > 1 ? strtoupper(explode(' ', \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][1], 3)[1]) : 'UNKNOWN',
        //                     'grand_father_name' => count(explode(' ', \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][1], 3)) > 2 ? strtoupper(explode(' ', \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][1], 3)[2]) : 'UNKNOWN',
        //                     'gender' => strtoupper(\App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][2]),
        //                     'phone' => \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][11],
        //                     'gpa' => \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][9], 'dob' => \App\FourthRoundAmhCSVInArrayFormat::AMH_LIST[$index][3].'-01-01',
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // dd('done for testing');




















        // dd('stop');
        // \App\Models\Region::factory(4)->create();
        // //Zone creation
        // $quota = [0.4, 0.3, 0.3];
        // $region = 1;
        // for ($y = 0; $y < 3; $y++) {
        //     \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        // }
        // $quota = [0.3, 0.2, 0.1, 0.2, 0.2];
        // $region = 2;
        // for ($y = 0; $y < count($quota); $y++) {
        //     \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        // }
        // $quota = [0.5, 0.2, 0.1, 0.2];
        // $region = 3;
        // for ($y = 0; $y < count($quota); $y++) {
        //     \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        // }
        // $quota = [0.1, 0.3, 0.6];
        // $region = 4;
        // for ($y = 0; $y < count($quota); $y++) {
        //     \App\Models\Zone::factory(1)->create(['region_id' => $region, 'qoutaInpercent' => $quota[$y]]);
        // }
        // //Woreda creation
        // $zonesCount = Zone::count();
        // $quotas = [
        //     [0.2, 0.4, 0.4],
        //     [0.2, 0.5, 0.1, 0.2],
        //     [0.2, 0.2, 0.1, 0.3, 0.2]
        // ];
        // $zone = 1;
        // $iterate = 0;
        // for ($x = 0; $x < $zonesCount; $x++) {
        //     $quota = $quotas[$iterate];
        //     for ($y = 0; $y < count($quota); $y++) {
        //         \App\Models\Woreda::factory(1)->create(['zone_id' => $zone, 'qoutaInpercent' => $quota[$y]]);
        //     }
        //     $zone++;
        //     $iterate++;
        //     if ($iterate > 2) {
        //         $iterate = 0;
        //     }
        // }
        // \App\Models\User::factory(200)->create();
        // $zones = Zone::all();
        // foreach ($zones as $zone) {
        // \App\Models\TraininingCenter::factory(1)->create(['zone_id' => $zone->id]);
        // }

        // $capacities = [6, 6, 5, 6, 7, 5, 6, 10, 7, 6, 4, 8, 7, 9, 8];
        // $trainingcenters = TraininingCenter::all();
        // foreach ($trainingcenters as $key => $center) {
        // $data = ['capacity' => $capacities[$key], 'trainining_center_id' => $center->id];
        // \App\Models\TrainingCenterCapacity::factory(1)->create($data);
        // }
        // $regions = Region::all();
        // $totalPersons = 100;
        // foreach ($regions as $region) {
        //     $regionQuota = $region->qoutaInpercent * 100;
        //     $zones = $region->zones;
        //     foreach ($zones as $zone) {
        //         $zoneQuota = $zone->qoutaInpercent * $regionQuota;
        //         $woredas = $zone->woredas;
        //         $woredaCount = 0;
        //         foreach ($woredas as  $woreda) {
        //             $woredaQuota = round($woreda->qoutaInpercent * $zoneQuota);
        //             for ($x = 0; $x < $woredaQuota; $x++)
        //                 \App\Models\Volunteer::factory(1)->create(['woreda_id' => $woreda->id]);
        //         }
        //     }
        // }
        // $this->approveAllVolunteers();
        // DatabaseSeeder::woredaIntake();
        // $this->woredaIntake();
    }

    // public static function woredaIntake()
    // {
    //     $intakes = [6, 6, 5, 6, 7, 5, 6, 10, 7, 6, 4, 8, 7, 9, 8];
    //     $trainingSession = TrainingSession::availableSession()->first();
    //     // dd('aj');
    //     foreach ($intakes as $intake) {
    //         WoredaIntake::create([
    //             'training_session_id' => $trainingSession->id,
    //             'woreda_id' => DatabaseSeeder::randomUniqueWoreda($trainingSession), 'intake' => $intake
    //         ]);
    //     }
    // }

    // public static function randomUniqueWoreda($trainingSession)
    // {
    //     $woredaCount = Woreda::count();
    //     $woredaId = mt_rand(1, $woredaCount);
    //     if (WoredaIntake::where(['training_session_id' => $trainingSession->id, 'woreda_id' => $woredaId])->count() > 0) {
    //         return DatabaseSeeder::randomUniqueWoreda($trainingSession);
    //     }

    //     return $woredaId;
    // }

    // public function approveAllVolunteers()
    // {
    //     foreach (Volunteer::all() as $v)
    //         ApprovedApplicant::create(['training_session_id' => 1, 'volunteer_id' => $v->id, 'status' => 1]);
    // }
}
