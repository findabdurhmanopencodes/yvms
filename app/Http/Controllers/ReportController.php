<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\TrainingPlacement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
    public function index()
    {

        $tsID = request()->route('training_session');
        $reportName = request()->route('report_name');

        if ($reportName == 'regional-contribution') {
            return  $this->trainingCentersVolunteerRegionalDistribution($tsID);
        }
        if ($reportName == 'regional-contribution-to-training-center') {
            // return $this->trainginCenersVolenteerRegionalDistribution();
        }
        if ($reportName == 'placed-volunteers-list') {
            return $this->placedVolunteersList($tsID);
        }
    }

    public function placedVolunteersList($tsID)
    {
        $trPlacement = TrainingPlacement::where(['training_session_id' => $tsID])->get();
        $pdf = PDF::loadView('report.placed_volunteers_list', ['placedVolunteers' => $trPlacement]);
        return $pdf->stream();
    }

    public function trainingCentersVolunteerRegionalDistribution($ts)
    {

        $regionalAllowedQuota = DB::select("SELECT r.name as x, q.quantity as y FROM `qoutas` q LEFT JOIN `regions` r ON q.quotable_id = r.id WHERE  q.training_session_id = $ts AND q.quotable_type = 'App\\\\Models\\\\Region'");
        $regionalApplied = DB::select("SELECT r.name as x, COUNT(v.id) as y FROM volunteers v LEFT JOIN woredas w ON v.woreda_id = w.id LEFT JOIN zones z ON w.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id WHERE v.training_session_id = $ts GROUP BY r.id");
        $placementRegionalContribution = DB::select("SELECT r.code as x, COUNT(tp.approved_applicant_id) as y FROM `training_placements` tp LEFT JOIN training_center_capacities tcc ON tp.training_center_capacity_id = tcc.id LEFT JOIN trainining_centers tc ON tcc.trainining_center_id = tc.id LEFT JOIN zones z ON tc.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id WHERE tp.training_session_id = $ts GROUP BY r.code");

        $regionalQoutaAppliedPlaced =  ['applied' => $regionalApplied, 'quota' => $regionalAllowedQuota, 'placed' => $placementRegionalContribution];

        // return View::make('report.regional_contributions');
        // $pdf = PDF::loadView('report.regional_contributions');
        // dd('Hello');
        // $pdf->render();

        // $pdf = PDF::loadHTML('<h1>Hello World</h1>');
        // return $pdf->stream();

        // $pdf = $this->getCredential(Auth::user());

        $pdf = PDF::loadView('report.regional_contributions', ['regionalQoutaAppliedPlaced' => $regionalQoutaAppliedPlaced, 'placedVolunteers' => TrainingPlacement::all()]);
        return $pdf->stream();

        return view('report.regional_contributions', ['regionalQoutaAppliedPlaced' => $regionalQoutaAppliedPlaced]);
    }
}
