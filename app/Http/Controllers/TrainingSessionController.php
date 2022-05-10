<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\ApprovedApplicant;
use App\Models\Qouta;
use App\Models\Region;
use App\Models\Status;
use App\Models\TrainingSession;
use App\Models\Volunteer;
use App\Models\Woreda;
use App\Models\Zone;
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
        $last_data_id = DB::table('training_sessions')->orderBy('id', 'desc')->first()?->id;
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
            'start_date' => ['required', 'date', 'after:' . $date_now_et],
            'end_date' => ['required', 'date', 'after:' . $request->get('start_date')],
            'registration_start_date' => ['required', 'date', 'after:' . $request->get('start_date'), 'before:' . $request->get('end_date')],
            'registration_dead_line' => ['required', 'date', 'after:' . $request->get('registration_start_date'), 'before:' . $request->get('end_date')],
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
            $region_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $region->id)->where('qoutable_type', 'App\Models\Region');

            if ($region_validate) {
                $reg_qouta = $region->qoutaInpercent;
                $qouta->training_session_id = $trainingSession->id;
                $reg_sum = intval($request->get('quantity') * $reg_qouta) * sizeof($regions);
                $check_reg_qua = ($request->get('quantity') - $reg_sum) - $key;
                if ($check_reg_qua > 0) {
                    $qouta->quantity = intval($request->get('quantity') * $reg_qouta) + 1;
                    $region->quotas()->save($qouta);
                } else {
                    $qouta->quantity = intval($request->get('quantity') * $reg_qouta);
                    $region->quotas()->save($qouta);
                }
                foreach ($region->zones as $keyzone => $zone) {
                    if ($zone) {
                        $qouta = new Qouta();
                        $zone_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $zone->id)->where('qoutable_type', 'App\Models\Region');
                        if ($zone_validate) {
                            $zone_quantity = $qouta::where('quotable_id', $region->id)->where('quotable_type', 'App\Models\Region')->pluck('quantity')[0];
                            $zone_qouta = $zone->qoutaInpercent;
                            $qouta->training_session_id = $trainingSession->id;
                            $zone_sum = intval($zone_quantity * $zone_qouta) * sizeof($region->zones);
                            // dump($zone_quantity*$zone_qouta);
                            $check_zone_qua = $zone_quantity - $zone_sum;

                            $check_zone_check = $check_zone_qua - $keyzone;

                            // dump($zone_quantity - $zone_sum);
                            if ($check_zone_check > 0) {
                                $qouta->quantity = intval($zone_quantity * $zone_qouta) + 1;
                                $zone->quotas()->save($qouta);
                            } else {
                                $qouta->quantity = intval($zone_quantity * $zone_qouta);
                                $zone->quotas()->save($qouta);
                            }

                            foreach ($zone->woredas as $keyworeda => $woreda) {
                                if ($woreda) {
                                    $qouta = new Qouta();
                                    $woreda_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $woreda->id)->where('qoutable_type', 'App\Models\Region');
                                    if ($woreda_validate) {
                                        $woreda_quantity = $qouta::where('quotable_id', $zone->id)->where('quotable_type', 'App\Models\Zone')->pluck('quantity')[0];
                                        $woreda_qouta = $woreda->qoutaInpercent;
                                        $qouta->training_session_id = $trainingSession->id;
                                        $woreda_sum = intval($woreda_quantity * $woreda_qouta) * sizeof($zone->woredas);

                                        $check_woreda_qua = $woreda_quantity - $woreda_sum;

                                        $check_woreda_check = $check_woreda_qua - $keyworeda;

                                        if ($check_woreda_check > 0) {
                                            $qouta->quantity = intval($woreda_quantity * $woreda_qouta) + 1;
                                            $woreda->quotas()->save($qouta);
                                        } else {
                                            $qouta->quantity = intval($woreda_quantity * $woreda_qouta);
                                            $woreda->quotas()->save($qouta);
                                        }
                                    } else {
                                        dump('woreda');
                                    }
                                }
                            }
                        } else {
                            dump('zone');
                        }
                    }
                }
            } else {
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
        return view('training_session.show', compact('trainingSession'));
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
            'start_date' => ['required', 'date', 'after:' . $date_now_et],
            'end_date' => ['required', 'date', 'after:' . $request->get('start_date')],
            'registration_start_date' => ['required', 'date', 'after:' . $request->get('start_date'), 'before:' . $request->get('end_date')],
            'registration_dead_line' => ['required', 'date', 'after:' . $request->get('registration_start_date'), 'before:' . $request->get('end_date')],
            'quantity' => 'required'
        ]);
        $zones = Zone::all();
        $woredas = Woreda::all();
        // $data = $request->validate(['name' => 'required|string|unique:training_sessions,name,'.$role->id]);
        $trainingSession->update($data);
        $qouta_all = $qouta->all();
        foreach ($qouta_all as $key => $qou) {
            $qo = Qouta::where('training_session_id', $trainingSession->id);
            $qo->delete();
        }
        $regions = Region::all();
        $reg_sum = 0;
        foreach ($regions as $key => $region) {
            $qouta = new Qouta();
            $region_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $region->id)->where('qoutable_type', 'App\Models\Region');

            if ($region_validate) {
                $reg_qouta = $region->qoutaInpercent;
                $qouta->training_session_id = $trainingSession->id;
                $reg_sum = intval($request->get('quantity') * $reg_qouta) * sizeof($regions);
                $check_reg_qua = ($request->get('quantity') - $reg_sum) - $key;
                if ($check_reg_qua > 0) {
                    $qouta->quantity = intval($request->get('quantity') * $reg_qouta) + 1;
                    $region->quotas()->save($qouta);
                } else {
                    $qouta->quantity = intval($request->get('quantity') * $reg_qouta);
                    $region->quotas()->save($qouta);
                }

                foreach ($region->zones as $keyzone => $zone) {
                    if ($zone) {
                        $qouta = new Qouta();
                        $zone_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $zone->id)->where('qoutable_type', 'App\Models\Region');
                        if ($zone_validate) {
                            $zone_quantity = $qouta::where('quotable_id', $region->id)->where('quotable_type', 'App\Models\Region')->pluck('quantity')[0];
                            $zone_qouta = $zone->qoutaInpercent;
                            $qouta->training_session_id = $trainingSession->id;
                            $zone_sum = intval($zone_quantity * $zone_qouta) * sizeof($region->zones);
                            // dump($zone_quantity*$zone_qouta);
                            $check_zone_qua = $zone_quantity - $zone_sum;

                            $check_zone_check = $check_zone_qua - $keyzone;

                            // dump($zone_quantity - $zone_sum);
                            if ($check_zone_check > 0) {
                                $qouta->quantity = intval($zone_quantity * $zone_qouta) + 1;
                                $zone->quotas()->save($qouta);
                            } else {
                                $qouta->quantity = intval($zone_quantity * $zone_qouta);
                                $zone->quotas()->save($qouta);
                            }
                            foreach ($zone->woredas as $keyworeda => $woreda) {
                                if ($woreda) {
                                    $qouta = new Qouta();
                                    $woreda_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $woreda->id)->where('qoutable_type', 'App\Models\Region');
                                    if ($woreda_validate) {
                                        $woreda_quantity = $qouta::where('quotable_id', $zone->id)->where('quotable_type', 'App\Models\Zone')->pluck('quantity')[0];
                                        $woreda_qouta = $woreda->qoutaInpercent;
                                        // dump($woreda_quantity);
                                        $qouta->training_session_id = $trainingSession->id;
                                        $woreda_sum = intval($woreda_quantity * $woreda_qouta) * sizeof($zone->woredas);

                                        $check_woreda_qua = $woreda_quantity - $woreda_sum;

                                        $check_woreda_check = $check_woreda_qua - $keyworeda;

                                        if ($check_woreda_check > 0) {
                                            $qouta->quantity = intval($woreda_quantity * $woreda_qouta) + 1;
                                            $woreda->quotas()->save($qouta);
                                        } else {
                                            $qouta->quantity = intval($woreda_quantity * $woreda_qouta);
                                            $woreda->quotas()->save($qouta);
                                        }
                                    } else {
                                        dump('woreda');
                                    }
                                }
                            }
                        } else {
                            dump('zone');
                        }
                    }
                }
            } else {
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
        $quota = Qouta::with('quotable')->where('training_session_id', $trainingSession->id)->get();
        $regions = Region::with(['zones', 'quotas'])->get();
        return view('training_session.quota_allocation', compact(['trainingSession', 'regions', 'quota']));
    }

    public function screen($id)
    {
        $arr = [];
        $accepted_arr = [];
        $sum = 0;
        $a = [];
        $status_table = Status::where('acceptance_status', 1)->orderBy('id', 'asc')->get();
        if ($status_table) {
            foreach ($status_table as $key => $stat) {
                array_push($arr, Volunteer::where('id', $stat->volunteer_id)->get()[0]);
            }
            $grouped_array_male = array();
            $grouped_array_female = [];

            $arr_female = [];
            $arr_male = [];

            foreach ($arr as $key => $value) {
                if ($value->gender == 'F') {
                    array_push($arr_female, $value);
                } elseif ($value->gender == 'M') {
                    array_push($arr_male, $value);
                }
            }

            foreach ($arr_male as $element) {
                $grouped_array_male[$element['woreda_id']][] = $element;
            }

            foreach ($arr_female as $element) {
                $grouped_array_female[$element['woreda_id']][] = $element;
            }

            foreach ($grouped_array_male as $key => $group) {
                $quota_woreda = Qouta::where('training_session_id', $id)->where('quotable_id', $key)->where('quotable_type', 'App\Models\Woreda')->get()[0]->quantity;
                // dump($quota_woreda);

                if ($quota_woreda >= sizeof($group)) {
                    // dump('true');
                    foreach ($group as $key => $vol) {
                        array_push($accepted_arr, $vol);
                    }
                } else {
                    // dump('false');
                    sort($group);
                    $new_arr = array_slice($group, 0, $quota_woreda, true);
                    foreach ($new_arr as $key => $value) {
                        array_push($accepted_arr, $value);
                    }
                }
            }

            foreach ($grouped_array_female as $key => $group) {
                $quota_woreda = Qouta::where('training_session_id', $id)->where('quotable_id', $key)->where('quotable_type', 'App\Models\Woreda')->get()[0]->quantity;

                if ($quota_woreda >= sizeof($group)) {
                    foreach ($group as $key => $vol) {
                        array_push($accepted_arr, $vol);
                    }
                } else {
                    sort($group);
                    $new_arr = array_slice($group, 0, $quota_woreda, true);
                    foreach ($new_arr as $key => $value) {
                        array_push($accepted_arr, $value);
                    }
                }
            }

            $a = [];
            $b = [];

            $train_session = TrainingSession::where('id', $id)->get()[0]->quantity;

            if (sizeof($accepted_arr) > $train_session) {
                sort($accepted_arr);
                $new_slice_arr = array_slice($accepted_arr, 0, $train_session, true);
                foreach ($new_slice_arr as $key => $value) {
                    array_push($a, $value);
                }
            } else if (sizeof($accepted_arr) < $train_session) {
                $dif_arr = $train_session - sizeof($accepted_arr);
                $merge_arr = array_diff($arr, $accepted_arr);
                foreach ($merge_arr as $value) {
                    array_push($b, $value);
                }
                sort($b);
                $new_slice_merge_arr = array_slice($b, 0, $dif_arr, true);
                $merged_array = array_merge($accepted_arr, $new_slice_merge_arr);
                foreach ($merged_array as $key => $value) {
                    array_push($a, $value);
                }
            } else {
                foreach ($accepted_arr as $key => $value) {
                    array_push($a, $accepted_arr);
                }
            }
            $approved_applicants = ApprovedApplicant::where('training_session_id', $id)->get();
            foreach ($approved_applicants as $key => $app_vol) {
                $app_vol->delete();
            }
            foreach ($a as $key => $accepted) {
                $approved_applicant = new ApprovedApplicant();
                $status = Status::where('volunteer_id', $accepted->id)->get()[0];
                $status->acceptance_status = 3;
                $status->save();
                $approved_applicant->training_session_id = $id;
                $approved_applicant->volunteer_id = $accepted->id;
                $approved_applicant->status = 1;
                $approved_applicant->save();
            }
        }
        return redirect()->route('applicant.verified', ['session' => $id])->with('message', 'Applicant approved successfully');
    }
}
