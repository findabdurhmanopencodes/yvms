<?php

namespace App\Http\Controllers;

use App\Console\Commands\TrainingPlacementCommand;
use App\Models\TrainingPlacement;
use App\Http\Requests\StoreTrainingPlacementRequest;
use App\Http\Requests\UpdateTrainingPlacementRequest;
use App\Models\ApprovedApplicant;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Woreda;
use App\Models\Zone;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class TrainingPlacementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TrainingPlacement::class, 'trainingPlacement');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,TrainingSession $trainingSession)
    {
        // $trainingSession = TrainingSession::availableSession()->first();
        $q = TrainingPlacement::query()->where('training_placements.training_session_id', $trainingSession->id);
        if ($request->get('training_center') != null) {
            $q->whereHas('trainingCenterCapacity.trainingCenter', function ($query) use ($request) {
                $query->where('id', $request->get('training_center'));
            });
        }
        if ($request->get('region') != null) {
            $q->whereHas('approvedApplicant.volunteer.woreda.zone.region', function ($query) use ($request) {
                $query->where('id', $request->get('region'));
            });
        }
        if ($request->get('zone') != null) {
            $q->whereHas('approvedApplicant.volunteer.woreda.zone', function ($query) use ($request) {
                $query->where('id', $request->get('zone'));
            });
        }
        if ($request->get('woreda') != null) {
            $q->whereHas('approvedApplicant.volunteer.woreda', function ($query) use ($request) {
                $query->where('id', $request->get('woreda'));
            });
        }
        $user = Auth::user();
        if ($user->getCordinatingRegion() != null) {
            $q->whereHas('approvedApplicant.volunteer.woreda.zone.region', function ($query) use ($user) {
                $query->where('id', $user->getCordinatingRegion()->id);
            });
        }
        if ($user->getCordinatingZone() != null) {
            $q->whereHas('approvedApplicant.volunteer.woreda.zone', function ($query) use ($user) {
                $query->where('id', $user->getCordinatingZone()->id);
            });
        }
        if($request->get('print')){
            $pdf = PDF::loadView('report.placed_volunteers_list', ['placedVolunteers' => $q->get()]);
            return $pdf->stream();
        }

        $placedVolunteers = $q->paginate(10);
         if ($user->getCordinatingRegion() != null) {
            $zones = $user->getCordinatingRegion()->zones;
            $woredas =  Woreda::whereRelation('zone.region', 'id', $user->getCordinatingRegion()->id)->get();
        } else {
            $zones = Zone::all();
            $woredas = $user->getCordinatingZone() != null ? $user->getCordinatingZone()->woredas : Woreda::all();
        }


        return view('placement.index', ['trainingSession' => $trainingSession, 'placedVolunteers' => $placedVolunteers, 'trainingCenterCapacities' =>  TrainingCenterCapacity::where('training_session_id', $trainingSession->id)->get(), 'zones' => $zones, 'woredas' => $woredas, 'regions' => Region::all(), 'training_centers' => TraininingCenter::all()]);
    }

    public function placeManually(Request $request)
    {

        if (TrainingPlacement::where(['approved_applicant_id' => $request->route('approvedApplicant'), 'training_session_id' => $request->route('training_session')])->first()) {
            TrainingPlacement::where(['approved_applicant_id' => $request->route('approvedApplicant'), 'training_session_id' => $request->route('training_session')])->first()->delete();
        }
        ApprovedApplicant::where(['id' => $request->route('approvedApplicant')])->update(['status' => 2]);
        TrainingPlacement::create([
            'training_session_id' => $request->route('training_session'), 'approved_applicant_id' => $request->route('approvedApplicant'),
            'training_center_capacity_id' => $request->get('training_center_capacity_id')
        ]);
        //id must

        return  redirect(route('session.placement.index', [$request->route('training_session')]))->with(['message' => 'Successfully Placed']);
    }
    public function resetPlacement()
    {
        TrainingPlacement::where(['training_session_id' => request()->route('training_session')])->delete();
        return redirect()->back()->with(['message' => 'Successfully Cleared']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingPlacementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingPlacementRequest $request)
    {
        //
    }

    public function place(Request $request,$trainingSessionId)
    {
        // $output = shell_exec('php ../artisan training:place');
        // if (!$output)
        //     $message = 'Succefully Placed Volunteers';
        // else
        //     $message = $output;
        $tp = new TrainingPlacementCommand();
        $tp->place($trainingSessionId);
        return redirect(route('session.placement.index', [$request->route('training_session')]))->with('message', 'Succefully Placed');
    }

    public function changePlacement(Request $request)
    {

        $request->validate([
            'training_center_capacity_id' => 'required'
        ]);
        TrainingPlacement::where('id', '=', $request->route('training_placement'))->update(['training_center_capacity_id' => $request->get('training_center_capacity_id')]);
        return redirect(route('session.placement.index', [$request->route('training_session')]))->with('message', 'Successfully Changed Placement');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingPlacement $trainingPlacement)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingPlacement $trainingPlacement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingPlacementRequest  $request
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingPlacementRequest $request, TrainingPlacement $trainingPlacement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingPlacement $trainingPlacement)
    {
        //
    }
}
