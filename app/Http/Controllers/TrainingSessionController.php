<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\TrainingSession;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class TrainingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(TrainingSession::select())->make(true);
        }

        $training_session = TrainingSession::all();
        return view('training_session.index', compact('training_session'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('training_session.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingSessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        $date_now = Carbon::now();
        $date_now_et = DateTimeFactory::fromDateTime($date_now)->format('d/m/y');
        $request->validate([
            'start_date' => ['required', 'date', 'after:'.$date_now_et],
            'end_date' => ['required', 'date', 'after:'.$request->get('start_date')],
            'registration_start_date' => ['required', 'date', 'after:'.$request->get('start_date'), 'before:'.$request->get('end_date')],
            'registration_dead_line' => ['required', 'date', 'after:'.$request->get('registration_start_date'), 'before:'.$request->get('end_date')],
            'quantity' => 'required'
        ]);

        $trainingSession = new TrainingSession();
        $trainingSession->start_date = new DateTime($request->get('start_date'));
        $trainingSession->end_date = new DateTime($request->get('end_date'));
        $trainingSession->registration_start_date = new DateTime($request->get('registration_start_date'));
        $trainingSession->registration_dead_line = new DateTime($request->get('registration_dead_line'));
        $trainingSession->quantity = $request->get('quantity');
        $trainingSession->status = 0;
        $trainingSession->save();
        return redirect()->route('training_session.index')->with('message', 'Region edited successfully');
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
    public function edit(TrainingSession $training_session)
    {
        return view('training_session.create', compact('training_session'));
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
        $trainingSession->delete();
        return response()->json(array('msg' => 'deleted successfully'));
    }
}
