<?php

namespace App\Http\Controllers;

use App\Models\VolunteerResourceHistory;
use App\Http\Requests\StoreVolunteerResourceHistoryRequest;
use App\Http\Requests\UpdateVolunteerResourceHistoryRequest;
use App\Models\TraininingCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VolunteerResourceHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        dd('vv');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($training_session_id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVolunteerResourceHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($training_session_id, Request $request)
    {
        $amount = $request->get('amount');
        $training_center = $request->get('training_center');
        $resource_id = $request->get('resource_id');
        $training_session_id = $request->get('training_session');
        $training_session_id = $request->get('training_session');
        $volunteer_id = $request->get('volunteer_id');
        $trainingCenterResourceCurrentBalance = TraininingCenter::find($training_center)->resources()->latest()->first()->pivot->current_balance;

        $resource_avalilable_center = DB::table('resource_trainining')->where('resource_id', $resource_id)->where('training_session_id', $training_center)->where('trainining_center_id', $training_center)->first()->current_balance;
        if ($amount > $resource_avalilable_center) {
            return  redirect()->back()->withErrors('Error!! insufficent Ballance For this operation');
        } else {
            VolunteerResourceHistory::create(['amount' => $amount, 'training_center_id' => $training_center, 'resource_id' => $resource_id, 'training_session_id' => $training_session_id, 'volunteer_id' => $volunteer_id]);
            DB::table('resource_trainining')->where('resource_id', $resource_id)->where('training_session_id', $training_center)->where('trainining_center_id', $training_center)->update([
                'current_balance' => $trainingCenterResourceCurrentBalance - $amount
            ]);

            return redirect()->back()->with('msg', 'sucessfuily Resource Assigned');
        }


        // if()



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VolunteerResourceHistory  $volunteerResourceHistory
     * @return \Illuminate\Http\Response
     */
    public function show(VolunteerResourceHistory $volunteerResourceHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolunteerResourceHistory  $volunteerResourceHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(VolunteerResourceHistory $volunteerResourceHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVolunteerResourceHistoryRequest  $request
     * @param  \App\Models\VolunteerResourceHistory  $volunteerResourceHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVolunteerResourceHistoryRequest $request, VolunteerResourceHistory $volunteerResourceHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerResourceHistory  $volunteerResourceHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerResourceHistory $volunteerResourceHistory)
    {
        //
    }
}
