<?php

namespace Database\Seeders;

use App\Models\EducationalLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationalLevel::create(['name' => 'BSC',]);
        EducationalLevel::create(['name' => 'MSC',]);
        EducationalLevel::create(['name' => 'PHD',]);
    }
}
