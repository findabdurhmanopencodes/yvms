<?php

namespace Database\Seeders;

use App\Models\TraininingCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TraininingCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TraininingCenter::create(['name'=>'Test university','code'=>'Te','zone_id'=>1]);

    }
}
