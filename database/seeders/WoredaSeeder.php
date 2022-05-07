<?php

namespace Database\Seeders;

use App\Models\Woreda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WoredaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Woreda::create(['name'=>'Liko','code'=>'L','zone_id'=>1, 'qoutaInpercent'=> 0.3]);
        Woreda::create(['name'=>'Fiko','code'=>'K','zone_id'=>1, 'qoutaInpercent'=>0.1]);
        Woreda::create(['name'=>'Inko','code'=>'I','zone_id'=>2, 'qoutaInpercent'=>0.2]);
    }
}
