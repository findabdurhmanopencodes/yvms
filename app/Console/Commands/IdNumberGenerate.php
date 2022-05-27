<?php
namespace App\Console\Commands;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\Volunteer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class IdNumberGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'id:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating unique In Number';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (TrainingPlacement::all() as $key=>$placement) {
            $idNumber = 'MOP-' . $placement->trainingCenterCapacity->trainingCenter?->code . '-' . str_pad($key+1, 6, "0", STR_PAD_LEFT) . '/' . TrainingSession::find(1)->id;
            if( Volunteer::find($placement->approvedApplicant?->volunteer?->id)->id_number==null){
                Volunteer::find($placement->approvedApplicant?->volunteer?->id)->update(['id_number'=>$idNumber]);
            }
        }
        Artisan::call('volunteer:placment:notify:all');
    }
}
