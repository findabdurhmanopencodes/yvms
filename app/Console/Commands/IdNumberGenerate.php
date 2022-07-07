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
        $lastVolunteer = DB::table('volunteers')
            ->select('*')
            ->where('volunteers.training_session_id', '=', $trainingSessionId)
            ->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
            ->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
            ->orderBy('id_number', 'desc')
            ->first();
        $start = 0;
        if ($lastVolunteer->id_number != null) {
            $exploded = explode('/', $lastVolunteer->id_number);
            $exploded = explode('-', $exploded[0]);
            $start = (int)$exploded[2];
        }
        $volunteers = DB::table('volunteers')
            ->select(['volunteers.id as volunteerId', 'training_placements.id as placmentId', 'trainining_centers.code'])
            ->where('volunteers.training_session_id', '=', $trainingSessionId)
            ->where('volunteers.id_number', '=', null)
            ->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
            ->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
            ->join('training_center_capacities', 'training_center_capacities.id', '=', 'training_placements.training_center_capacity_id')
            ->join('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
            ->take(10)->get();
        $volunteerIds = [];
        foreach ($volunteers as $volunteer) {
            // $idNumber = 'MoP-' . $placement->trainingCenterCapacity?->trainingCenter?->code . '-' . str_pad($key+1, 5, "0", STR_PAD_LEFT) . '/' . TrainingSession::find(1)->id;
            array_push($volunteerIds,['id_number'=>'MoP-'.strtoupper($volunteer->code).'-'.str_pad($start+1, 5, "0", STR_PAD_LEFT) .'/'.$trainingSessionId]);
            $start++;
        }
        dump($volunteerIds);
        // dump(count($volunteers));
        // dump($start);
        dd('new one');
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
