<?php

namespace App\Console\Commands;

use App\Constants;
use App\Models\ApprovedApplicant;
use App\Models\Region;
use App\Models\Status;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\VolunteerDeployment;
use App\Models\Woreda;
use App\Models\WoredaIntake;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VoluteerDeploymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volunteer:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploys Volunteers to Woredas Around the country';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->deploy();
        echo "Deployed Successfully\n";
        return 0;
    }

    public function applicantExceptRegion($region, Collection $applicants)
    {
        return $applicants->filter(function ($value, $key) use ($region) {
            return $value->region->id != $region;
        });
    }

    public function randomVolunteerFromRegion(Collection $graduatedVolunteers, Region $region)
    {
        $regionVolunteers = $graduatedVolunteers->filter(function ($graduatedVolunteer) use ($region) {
            return $graduatedVolunteer->region->id == $region->id;
        });
        if ($regionVolunteers->isEmpty()) {
            return null;
        }
        return $regionVolunteers->random();
    }

    public function regionsExceptThis(Collection $regions, Region $region, Collection $woredas): Collection
    {
        return $regions->filter(function ($currentRegion) use ($region, $woredas) {
            $woredasInRegion = $woredas->filter(function ($woreda) use ($currentRegion) {
                return $woreda->region->id == $currentRegion->id;
            });
            return $currentRegion->id != $region->id && $woredasInRegion->count() > 0;
        });
    }

    public function getRandomWoredaFromRegion(Collection $woredas, Region $region): WoredaIntake
    {
        $regionalWoredas = $woredas->filter(function ($woreda) use ($region) {
            return $woreda->region->id == $region->id;
        });
        return $regionalWoredas->random();
    }

    public function deploy(TrainingSession $trainingSession)
    {
        $activeSession = $trainingSession;
        VolunteerDeployment::whereHas('trainingPlacement', function ($q) use ($activeSession) {
            $q->where(['training_session_id' => $activeSession->id]);
        })->delete();

       $graduatedVolunteers = TrainingPlacement::query()->whereRelation('approvedApplicant.volunteer.status', 'acceptance_status', '=', Constants::VOLUNTEER_STATUS_GRADUATED)->get();
        // $graduatedVolunteers = TrainingPlacement::all();

        $woredas = WoredaIntake::where(['training_session_id' => $activeSession->id])->where('intake', '>', 0)->get();

        $regions = Woreda::whereHas('woredaIntakes', function ($q) use ($activeSession) {
            $q->where(['training_session_id' => $activeSession->id])->where('intake', '>', 0);
        })->with(['zone.region'])->get()->pluck("zone.region")->unique('id');

        while (!$regions->isEmpty() && (!$graduatedVolunteers->isEmpty()) && (!$woredas->isEmpty())) {
            if ($regions->count() == 1 && $this->regionsExceptThis(Region::all(), $regions->first(), $woredas)->isEmpty()) {
                foreach ($graduatedVolunteers as $graduatedVolunteer) {
                    $selectedWoreda = $this->getRandomWoredaFromRegion($woredas, $regions->first());

                    VolunteerDeployment::create(['woreda_intake_id' => $selectedWoreda->id, 'training_placement_id' => $graduatedVolunteer->id]);
                    Status::where(['volunteer_id' => $graduatedVolunteer->approvedApplicant->volunteer_id])->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_DEPLOYED]);

                    $selectedWoreda->intake = $selectedWoreda->intake - 1;
                    $woredas = $woredas->filter(function ($woreda) {
                        return $woreda->intake > 0;
                    });
                }
                break;
            }
            foreach ($regions as $currentRegion) {
                foreach ($this->regionsExceptThis(Region::all(), $currentRegion, $woredas) as $exRegion) {
                    $selectedVolunteer = $this->randomVolunteerFromRegion($graduatedVolunteers, $currentRegion);

                    if ($selectedVolunteer == null) {
                        $regions = $regions->filter(function ($region) use ($currentRegion) {
                            return $region->id != $currentRegion->id;
                        });
                        break;
                    }
                    $selectedWoreda = $this->getRandomWoredaFromRegion($woredas, $exRegion);

                    VolunteerDeployment::create(['woreda_intake_id' => $selectedWoreda->id, 'training_placement_id' => $selectedVolunteer->id]);
                    Status::where(['volunteer_id' => $selectedVolunteer->approvedApplicant->volunteer_id])->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_DEPLOYED]);


                    $selectedWoreda->intake = $selectedWoreda->intake - 1;

                    $graduatedVolunteers = $graduatedVolunteers->filter(function ($graduatedVolunteer) use ($selectedVolunteer) {
                        return $graduatedVolunteer->id != $selectedVolunteer->id;
                    });

                    $woredas = $woredas->filter(function ($woreda) {
                        return $woreda->intake > 0;
                    });
                }
            }
        }
    }
}
