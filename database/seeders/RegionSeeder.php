<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::create(['name'=>'Oromia','code'=>'or', 'qoutaInpercent'=> 0.25]);
        Region::create(['name'=>'Amhara','code'=>'am', 'qoutaInpercent' => 0.2]);
    }
}
