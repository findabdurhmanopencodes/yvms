<?php

namespace App\Console\Commands;

use App\Imports\ApplicantImport;
use App\Models\Status;
use App\Models\Volunteer;
use App\Models\Woreda;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ImportVolunteers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volunteer:import {path} {trainingSessionId} {placment} {trainingCenterCapacityId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $trainingSessionId = $this->argument('trainingSessionId');
        $path = $this->argument('path');
        $placement = $this->argument('placment');
        $trainingCenterCapacityId = $this->argument('trainingCenterCapacityId');
        // php artisan volunteer:import 'E:\\Telegram\\JUV.xlsx' 1 1 1
        Excel::import(new ApplicantImport($trainingSessionId,$placement,$trainingCenterCapacityId), $path);
        return 1;
    }
}
