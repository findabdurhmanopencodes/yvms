<?php

namespace Database\Seeders;

use App\Models\TrainingSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TrainingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['name'=>'training_session.index']);
        TrainingSession::create([
            'start_date' => '2022-05-06',
            'end_date' => '2022-05-16',
            'moto' => 'We are in the community',
            'registration_start_date' => '2022-05-8',
            'registration_dead_line' => '2022-05-25',
            'quantity' => 2000,
            'status' => 0,
        ]);

        
    }
}
