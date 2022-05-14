<?php

namespace App\Http\Controllers;

use App\Models\TrainingPlacement;
use App\Http\Requests\StoreTrainingPlacementRequest;
use App\Http\Requests\UpdateTrainingPlacementRequest;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Woreda;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\Input;

class TrainingPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = TrainingPlacement::query()->where('training_placements.training_session_id', TrainingSession::availableSession()->first()->id);


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



        $placedVolunteers = $q->paginate(10);
        return view('placement.index', ['placedVolunteers' => $placedVolunteers, 'zones' => Zone::all(), 'woredas' => Woreda::all(), 'regions' => Region::all(), 'training_centers' => TraininingCenter::all()]);
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
