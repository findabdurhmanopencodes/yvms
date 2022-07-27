<?php

namespace Database\Seeders;

use App\Models\FeildOfStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeildOfStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        FeildOfStudy::create(['name'=>'Computer Science']);
        FeildOfStudy::create(['name'=>'Software Egnineering']);
        FeildOfStudy::create(['name'=>'Bio-Medical Engineering']);
    }
}
