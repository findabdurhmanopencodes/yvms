<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Zone::create(['name'=>'Jimma','code'=>'J','region_id'=>1, 'qoutaInpercent'=>0.2]);
        Zone::create(['name'=>'Metu','code'=>'M','region_id'=>1, 'qoutaInpercent'=>0.15]);
    }
}
