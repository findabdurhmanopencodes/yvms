<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\TrainingDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->can('Training.index'))
            return abort(403);
        $trainings = Training::paginate(10);
        return view('training.index', compact('trainings'));
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
     * @param  \App\Http\Requests\StoreTrainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingRequest $request)
    {
        if(!Auth::user()->can('Training.store'))
            return abort(403);
        Training::create($request->validated());
        return redirect()->back()->with('message', 'Training created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        if(!Auth::user()->can('Training.show'))
            return abort(403);
        $trainingDocuments = TrainingDocument::where('training_id',$training->id)->get();
        return view('training.show',compact('training','trainingDocuments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingRequest  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
        if(!Auth::user()->can('Training.update'))
            return abort(403);
        $training->update($request->validated());
        return redirect()->back()->with('message', 'Training updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        if(!Auth::user()->can('Training.destroy'))
            return abort(403);
        $training->delete();
        return redirect()->back()->with('message', 'Training deleted successfully');
    }
}
