<?php
namespace App\Console\Commands;

use App\Models\Training;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\Volunteer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class IdNumberGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'id:generate {trainingSessionId}';

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
        $trainingSessionId = $this->argument('trainingSessionId');
        $volunteerWithId =[];
        $volunteerWithoutId = [];
        dd(
            DB::table('volunteers')
            ->select('*')
            ->where('volunteers.training_session_id','=',$trainingSessionId)
            ->join('approved_applicants','volunteers.id','=','approved_applicants.volunteer_id')
            ->join('training_placements','approved_applicants.id','=','training_placements.approved_applicant_id')
            ->orderBy('id_number','desc')
            ->first()
        );
        // ('training_placements')
        // ->select('approved_applicants.volunteer_id')
        // ->where('training_placements.training_session_id',$trainingSessionId)
        // ->join('approved_applicants', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
        // ->first(1)
        // dd(DB::table('training_placements')
        // ->select('approved_applicants.volunteer_id')
        // ->where('training_placements.training_session_id',$trainingSessionId)
        // ->join('approved_applicants', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
        // ->first(1));
        // foreach(TrainingPlacement::join('id') as $key => $placement){
        //     dump($placement->id);
        // }
        dd('sd');

        // foreach (TrainingPlacement::all() as $key=>$placement) {
        //     if( Volunteer::find($placement->approvedApplicant?->volunteer?->id)->id_number==null){
        //         $idNumber = 'MoP-' . $placement->trainingCenterCapacity?->trainingCenter?->code . '-' . str_pad($key+1, 5, "0", STR_PAD_LEFT) . '/' . TrainingSession::find(1)->id;
        //         Volunteer::find($placement->approvedApplicant?->volunteer?->id)->update(['id_number'=>$idNumber]);
        //     }
        // }
        // Artisan::call('volunteer:placment:notify:all');
    }
}
