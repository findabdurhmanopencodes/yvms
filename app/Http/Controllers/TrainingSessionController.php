<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\Qouta;
use App\Models\Region;
use App\Models\TrainingSession;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $regions = Region::all();
        return view('training_session.index', compact(['training_session', 'regions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bool_Arr = [];
        $date_now = Carbon::now();
        $last_data_id = DB::table('training_sessions')->orderBy('id','desc')->first()->id;
        // dd($date_now->format('Y-m-d'));
        // $date_now_et = DateTimeFactory::fromDateTime($date_now)->format('m/d/y');
        // dd(new DateTime($date_now_et));
        $training_sessions = TrainingSession::all();
        // dd($training_sessions);
        if ($training_sessions) {
            foreach ($training_sessions as $training_session) {
                if ($training_session->end_date <= $date_now->format('Y-m-d')) {
                    return redirect()->route('training_session.index');
                }
            }
        }
            return view('training_session.create', compact('last_data_id'));
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

        $date_start =  DateTime::createFromFormat('d/m/Y', $request->get('start_date'));
        $date_end =  DateTime::createFromFormat('d/m/Y', $request->get('end_date'));
        $date_reg_start =  DateTime::createFromFormat('d/m/Y', $request->get('registration_start_date'));
        $date_reg_end =  DateTime::createFromFormat('d/m/Y', $request->get('registration_dead_line'));

        // foreach ($trainingSession::all() as $key => $session) {
            
        // }
        // dd('sdfsd');
        
        $trainingSession->start_date = DateTimeFactory::of($date_start->format('Y'), $date_start->format('m'), $date_start->format('d'))->toGregorian();
        $trainingSession->end_date = DateTimeFactory::of($date_end->format('Y'), $date_end->format('m'), $date_end->format('d'))->toGregorian();
        $trainingSession->registration_start_date = DateTimeFactory::of($date_reg_start->format('Y'), $date_reg_start->format('m'), $date_reg_start->format('d'))->toGregorian();
        $trainingSession->registration_dead_line = DateTimeFactory::of($date_reg_end->format('Y'), $date_reg_end->format('m'), $date_reg_end->format('d'))->toGregorian();
        $trainingSession->quantity = $request->get('quantity');
        $trainingSession->moto = $request->get('name');
        $trainingSession->status = 0;
        // $session = TrainingSession::create($trainingSession);
        $trainingSession->save();

        $regions = Region::all();
        foreach ($regions as $key => $region) {
            $qouta = new Qouta();
            $region_validate = $qouta->where('training_session',$trainingSession->id)->where('qoutable_id',$region->id)->where('qoutable_type','App\Models\Region');

            if ($region_validate) {
                $reg_qouta = $region->qoutaInpercent;
                $qouta->training_session_id = $trainingSession->id;
                $qouta->quantity = round($request->get('quantity')*$reg_qouta);
                $region->quotas()->save($qouta);
                foreach ($region->zones as $key => $zone) {
                    if ($zone) {
                        $qouta = new Qouta();
                        $zone_validate = $qouta->where('training_session',$trainingSession->id)->where('qoutable_id',$zone->id)->where('qoutable_type','App\Models\Region');
                        if ($zone_validate) {
                            $zone_quantity = $qouta::where('quotable_id',$region->id)->where('quotable_type','App\Models\Region')->pluck('quantity')[0];
                            $zone_qouta = $zone->qoutaInpercent;
                            $qouta->training_session_id = $trainingSession->id;
                            $qouta->quantity = round($zone_quantity*$zone_qouta);
                            // dump($qouta->quantity);
                            $zone->quotas()->save($qouta);
                            foreach ($zone->woredas as $key => $woreda) {
                                if ($woreda) {
                                    $qouta = new Qouta();
                                    $woreda_validate = $qouta->where('training_session',$trainingSession->id)->where('qoutable_id',$woreda->id)->where('qoutable_type','App\Models\Region');
                                    if ($woreda_validate) {
                                        $woreda_quantity = $qouta::where('quotable_id',$zone->id)->where('quotable_type','App\Models\Zone')->pluck('quantity')[0];
                                        $woreda_qouta = $woreda->qoutaInpercent;
                                        $qouta->training_session_id = $trainingSession->id;
                                        $qouta->quantity = round($woreda_quantity*$woreda_qouta);
                                        $woreda->quotas()->save($qouta);
                                    }else{
                                        dump('woreda');
                                    }
                                }
                            }
                        }else{
                            dump('zone');
                        }
                    }
                }
            }else{
                dump('region');
            }
        }
        // dd('sdffd');
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
        return view('training_session.show',compact('trainingSession'));
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
    public function update(UpdateTrainingSessionRequest $request, TrainingSession $trainingSession, Qouta $qouta)
    {
        $date_now = Carbon::now();
        $date_now_et = DateTimeFactory::fromDateTime($date_now)->format('d/m/y');
        $data = $request->validate([
            'start_date' => ['required', 'date', 'after:'.$date_now_et],
            'end_date' => ['required', 'date', 'after:'.$request->get('start_date')],
            'registration_start_date' => ['required', 'date', 'after:'.$request->get('start_date'), 'before:'.$request->get('end_date')],
            'registration_dead_line' => ['required', 'date', 'after:'.$request->get('registration_start_date'), 'before:'.$request->get('end_date')],
            'quantity' => 'required'
        ]);
        // $data = $request->validate(['name' => 'required|string|unique:training_sessions,name,'.$role->id]);
        $trainingSession->update($data);
        $qouta_all = $qouta->all();
        foreach ($qouta_all as $key => $qou) {
            $qo = Qouta::where('training_session_id',$trainingSession->id);
            $qo->delete();
        }
        $regions = Region::all();
        foreach ($regions as $key => $region) {
            $qouta = new Qouta();
            $region_validate = $qouta->where('training_session',$trainingSession->id)->where('qoutable_id',$region->id)->where('qoutable_type','App\Models\Region');

            if ($region_validate) {
                $reg_qouta = $region->qoutaInpercent;
                $qouta->training_session_id = $trainingSession->id;
                $qouta->quantity = round($request->get('quantity')*$reg_qouta);
                $region->quotas()->save($qouta);
                foreach ($region->zones as $key => $zone) {
                    if ($zone) {
                        $qouta = new Qouta();
                        $zone_validate = $qouta->where('training_session',$trainingSession->id)->where('qoutable_id',$zone->id)->where('qoutable_type','App\Models\Region');
                        if ($zone_validate) {
                            $zone_quantity = $qouta::where('quotable_id',$region->id)->where('quotable_type','App\Models\Region')->pluck('quantity')[0];
                            $zone_qouta = $zone->qoutaInpercent;
                            $qouta->training_session_id = $trainingSession->id;
                            $qouta->quantity = round($zone_quantity*$zone_qouta);
                            // dump($qouta->quantity);
                            $zone->quotas()->save($qouta);
                            foreach ($zone->woredas as $key => $woreda) {
                                if ($woreda) {
                                    $qouta = new Qouta();
                                    $woreda_validate = $qouta->where('training_session',$trainingSession->id)->where('qoutable_id',$woreda->id)->where('qoutable_type','App\Models\Region');
                                    if ($woreda_validate) {
                                        $woreda_quantity = $qouta::where('quotable_id',$zone->id)->where('quotable_type','App\Models\Zone')->pluck('quantity')[0];
                                        $woreda_qouta = $woreda->qoutaInpercent;
                                        $qouta->training_session_id = $trainingSession->id;
                                        $qouta->quantity = round($woreda_quantity*$woreda_qouta);
                                        $woreda->quotas()->save($qouta);
                                    }else{
                                        dump('woreda');
                                    }
                                }
                            }
                        }else{
                            dump('zone');
                        }
                    }
                }
            }else{
                dump('region');
            }
        }
        return redirect()->route('training_session.index')->with('message', 'Program updated successfully');
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
    public function showQuota(TrainingSession $trainingSession)
    {
        $regions = Region::with('zones')->get();
        return view('training_session.quota_allocation', compact(['trainingSession', 'regions']));
    }
}
