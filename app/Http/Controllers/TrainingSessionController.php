<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\TrainingSession;
use Illuminate\Support\Facades\Auth;

class TrainingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->can('training_session.index')){
            return abort(403);
        }
        $trainingSessions = TrainingSession::paginate(10);
        return view('training_session.index',compact('trainingSessions'));
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
     * @param  \App\Http\Requests\StoreTrainingSessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSession $trainingSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingSession $trainingSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingSessionRequest  $request
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingSessionRequest $request, TrainingSession $trainingSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession)
    {
        //
    }
}
