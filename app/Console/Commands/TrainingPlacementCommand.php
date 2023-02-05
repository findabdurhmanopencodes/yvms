<?php

namespace App\Console\Commands;

use App\Constants;
use App\Helpers\Helper;
use App\Models\ApprovedApplicant;
use App\Models\Region;
use App\Models\Status;
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
        // $this->place();
        exit;
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

    public function place($trainingSessionId)
    {
        $activeSession = TrainingSession::find($trainingSessionId);
        $errorMessage = null;

        if (!$activeSession)
            $errorMessage = "No Active Session is Available to place volunteers";

        $applicants = ApprovedApplicant::where('training_session_id',$trainingSessionId)->get();
        if ($applicants->isEmpty())
            $errorMessage = "No Approved Applicants Available to place";

        $trainingCenters = TrainingCenterCapacity::where(['training_session_id' => $activeSession->id])->get();

        if ($trainingCenters->isEmpty())
            $errorMessage = "No Traninig Center available for the selected";

        $regions = Region::all();

        if ($regions->isEmpty())
            $errorMessage = "No Region Available for the selected Session";

        $totalCapacity = TrainingCenterCapacity::query()->selectRaw("SUM(capacity) as total")->where(['training_session_id' => $activeSession->id])->first()->total;

        if ($applicants->count() > $totalCapacity)
            $errorMessage = "You have more Student's than the training centers can handle at the current session, you can increase the training center's capacity and try again ";

        if ($errorMessage)
            return redirect()->back()->withErrors($errorMessage);

        DB::delete('DELETE FROM training_placements where training_session_id = ?;', [$activeSession->id]);

        while (!$regions->isEmpty() && (!$applicants->isEmpty()) && (!$trainingCenters->isEmpty())) {
            if ($regions->count() == 1 && $this->regionsExceptThis(Region::all(), $regions->first()->id, $trainingCenters)->isEmpty()) {
                foreach ($applicants as $applicant) {

                    $selectedCenter = $this->getRandomTrainingCenterFromRegion($trainingCenters, $regions->first()->id);

                    TrainingPlacement::create(['training_session_id' => $activeSession->id, 'approved_applicant_id' => $applicant->id, 'training_center_capacity_id' => $selectedCenter->id]);
                    Status::where(['volunteer_id' => $applicant->volunteer_id])->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_PLACED]);
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
                    Status::where(['volunteer_id' => $selectedApplicant->volunteer_id])->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_PLACED]);

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
