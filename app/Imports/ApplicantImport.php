<?php

namespace App\Imports;

use App\Constants;
use App\Http\Controllers\WoredaController;
use App\Models\ApprovedApplicant;
use App\Models\Region;
use App\Models\Status;
use App\Models\TrainingPlacement;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
use App\Models\Woreda;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ApplicantImport implements ToCollection, WithStartRow
{
    protected $trainingSession, $placement, $trainingCenterCapacityId;
    public function __construct($trainingSession, $placement, $trainingCenterCapacityId)
    {
        $this->trainingSession = $trainingSession;
        $this->placement = $placement;
        $this->trainingCenterCapacityId = $trainingCenterCapacityId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $centerPlacement = TraininingCenter::findOrFail($this->placement);
        $volunteerData = [];
        foreach ($rows as $key => $value) {
            $fi_name = '';
            $fathe_name = '';
            $gr_name = '';
            $woredas_app = ltrim(rtrim(strtoupper($value[8])));
            $woreda = Woreda::Where('name', $woredas_app)->get()->first();
            if ($woreda) {
                $name_val = str_replace('  ', ' ', ltrim(rtrim($value[1])));
                $name = explode(' ', $name_val);
                if (count($name) >= 1) {
                    $fi_name = $name[0];
                }
                if (count($name) >= 2) {
                    $fathe_name = $name[1];
                }
                if (count($name) >= 3) {
                    $gr_name = $name[2];
                }
                $gpa = $value[9] || 0.0;
                $date = strtotime((string)$value[3]);
                $d = date('d/m/Y', $date);
                $data = ['first_name' => $fi_name, 'father_name' => $fathe_name, 'grand_father_name' => $gr_name, 'email' => '', 'dob' => new DateTime('01/01/1991'), 'gender' => $value[2], 'phone' => (string)$value[11], 'contact_name' => 'UNKNOWN', 'contact_phone' => 'UNKNOWN', 'gpa' => $gpa, 'password' => Hash::make('12345678'), 'training_session_id' => $this->trainingSession, 'woreda_id' => $woreda->id];
                array_push($volunteerData, $data);
            }
        }
        Volunteer::insert($volunteerData);
        $lastIds = Volunteer::orderBy('id', 'desc')->take(count($volunteerData))->pluck('id');
        $statusData = [];
        $approvedApplicants = [];
        for ($x = 0; $x < count($lastIds); $x++) {
            array_push($statusData, ['volunteer_id' => $lastIds[$x], 'acceptance_status' => 1]);
            array_push($approvedApplicants, ['training_session_id' => $this->trainingSession, 'volunteer_id' => $lastIds[$x], 'status' => Constants::VOLUNTEER_STATUS_PLACED]);
        }
        Status::insert($statusData);
        ApprovedApplicant::insert($approvedApplicants);
        $lastIdsForApproved = ApprovedApplicant::orderBy('id', 'desc')->take(count($volunteerData))->pluck('id');
        $trainingPlacements = [];
        for ($x = 0; $x < count($lastIdsForApproved); $x++) {
            array_push($trainingPlacements, ['training_center_capacity_id' => $this->trainingCenterCapacityId, 'approved_applicant_id' => $lastIdsForApproved[$x], 'training_session_id' => $this->trainingSession]);
        }
        TrainingPlacement::insert($trainingPlacements);
        return 1;
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
