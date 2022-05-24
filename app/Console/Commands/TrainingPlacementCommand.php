<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\ApprovedApplicant;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrainingPlacementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'training:place';

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
        $this->place();
        return 0;
    }

    public function applicantExceptRegion($region, Collection $applicants)
    {
        return $applicants->filter(function ($value, $key) use ($region) {
            return $value->region->id != $region;
        });
    }

    public function randomApplicantFromRegion(Collection $applicants, $region_id)
    {
        $region_applicants = $applicants->filter(function ($applicant) use ($region_id) {
            return $applicant->region->id == $region_id;
        });
        if ($region_applicants->isEmpty()) {
            return null;
        }

        return $region_applicants->random();
    }

    public function regionsExceptThis(Collection $regions, $region_id, Collection $trainingCenters)
    {
        return $regions->filter(function ($region) use ($region_id, $trainingCenters) {
            $cap = $trainingCenters->filter(function ($trCenter) use ($region) {
                return $trCenter->region->id == $region->id;
            });
            return $region->id != $region_id && $cap->count() > 0;
        });
    }

    public function getRandomTrainingCenterFromRegion(Collection $trainingCenters, $region_id)
    {
        $regionalTrainingCenters =  $trainingCenters->filter(function ($trainingCenter) use ($region_id) {
            return $trainingCenter->region->id == $region_id;
        });
        return $regionalTrainingCenters->random();
    }

    public function place()
    {
        // dd('aj');

        $activeSession = TrainingSession::availableSession()->first();
        DB::delete('DELETE FROM training_placements where training_session_id = ?;', [$activeSession->id]);

        $applicants = ApprovedApplicant::all();

        $trainingCenters = TrainingCenterCapacity::where(['training_session_id' => 1])->get();

        $regions = Region::all();

        // if($appl)

        while (!$regions->isEmpty() && (!$applicants->isEmpty())) {
            if ($regions->count() == 1 && $this->regionsExceptThis(Region::all(), $regions->first()->id, $trainingCenters)->isEmpty()) {
                foreach ($applicants as $applicant) {

                    $selectedCenter = $this->getRandomTrainingCenterFromRegion($trainingCenters, $regions->first()->id);

                   $tp= TrainingPlacement::create(['training_session_id' => $activeSession->id, 'approved_applicant_id' => $applicant->id, 'training_center_capacity_id' => $selectedCenter->id]);
                    // $id_number= Helper::IDGenerator(new Volunteer,'id_number',6,$tp->trainingCenterCapacity->trainingCenter,TrainingSession::find(request()->route('training_session'))->id);


                    // $volunteer= Volunteer::find($applicant->id);
                    // $volunteer->update(['id_number'=>$id_number]);


                    $selectedCenter->capacity =  $selectedCenter->capacity - 1;
                    $trainingCenters = $trainingCenters->filter(function ($trainingCenter) {
                        return $trainingCenter->capacity > 0;
                    });
                }
                break;
            }
            foreach ($regions as $currentRegion) {

                foreach ($this->regionsExceptThis(Region::all(), $currentRegion->id, $trainingCenters) as $exRegion) {
                    $selectedApplicant = $this->randomApplicantFromRegion($applicants, $currentRegion->id);

                    if ($selectedApplicant == null) {
                        $regions = $regions->filter(function ($region) use ($currentRegion) {
                            return $region->id != $currentRegion->id;
                        });
                        break;
                    }
                    $selectedCenter = $this->getRandomTrainingCenterFromRegion($trainingCenters, $exRegion->id);

                    $tp = TrainingPlacement::create(['training_session_id' => $activeSession->id, 'approved_applicant_id' => $selectedApplicant->id, 'training_center_capacity_id' => $selectedCenter->id]);
                    //id must generate here
                //     $id_number= Helper::IDGenerator(new Volunteer,'id_number',6,$tp->trainingCenterCapacity->trainingCenter,TrainingSession::find(request()->route('training_session'))->id);
                //   $volunteer= Volunteer::find($selectedApplicant->id);
                //   $volunteer->update(['id_number'=>$id_number]);


                    $selectedCenter->capacity = $selectedCenter->capacity - 1;

                    $applicants = $applicants->filter(function ($applicant) use ($selectedApplicant) {
                        return $applicant->id != $selectedApplicant->id;
                    });

                    $trainingCenters = $trainingCenters->filter(function ($trainingCenter) {
                        return $trainingCenter->capacity > 0;
                    });
                }
            }
        }
    }
}
