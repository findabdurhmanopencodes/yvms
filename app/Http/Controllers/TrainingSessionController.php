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
use League\CommonMark\Extension\SmartPunct\Quote;

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
            // 'start_date' => ['required', 'between:' . $date_now_et.','.$request->get('end_date')],
            // // 'end_date' => ["required", "after:". $request->get('start_date')],
            // 'registration_start_date' => ['required', 'between:' . $request->get('start_date').','.$request->get('end_date')],
            // 'registration_dead_line' => ['required', 'between:' . $request->get('registration_start_date').','.$request->get('end_date')],
            // 'quantity' => 'required'
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
        $sum = 0;
        $arr = [];
        foreach ($regions as $reg) {
            if ($reg->status == 0) {
                $sum+=$reg->qoutaInpercent;
            }else{
                array_push($arr, $reg);
            }
        }

        if ($arr) {
            $regs = [];
            $division = $sum/sizeof($arr);

            foreach ($arr as $reg_new) {
                $reg_new->qoutaInpercent = $reg_new->qoutaInpercent + $division;
                array_push($regs, $reg_new);
            }

            $regions = $regs;
            foreach ($regions as $key => $region) {
                $qouta = new Qouta();
                $region_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $region->id)->where('qoutable_type', 'App\Models\Region');

                $sum_zon = 0;
                $arr_zon = [];
                foreach ($region->zones as $zon) {
                    if ($zon->status == 0) {
                        $sum_zon+=$zon->qoutaInpercent;
                    }else{
                        array_push($arr_zon, $zon);
                    }
                }

                if ($arr_zon) {
                    $zons = [];
                    $division_zon = $sum_zon/sizeof($arr_zon);

                    foreach ($arr_zon as $zon_new) {
                        $zon_new->qoutaInpercent = $zon_new->qoutaInpercent + $division_zon;
                        array_push($zons, $zon_new);
                    }
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
                        foreach ($zons as $keyzone => $zone) {
                            if ($zone) {
                                $qouta = new Qouta();
                                $zone_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $zone->id)->where('qoutable_type', 'App\Models\Region');
                                $sum_wor = 0;
                                $arr_wor = [];
                                foreach ($zone->woredas as $wor) {
                                    if ($wor->status == 0) {
                                        $sum_wor+=$wor->qoutaInpercent;
                                    }else{
                                        array_push($arr_wor, $wor);
                                    }
                                }
                                if ($arr_wor) {
                                    $wors = [];
                                    $division_wor = $sum_wor/sizeof($arr_wor);

                                    foreach ($arr_wor as $wor_new) {
                                        $wor_new->qoutaInpercent = $wor_new->qoutaInpercent + $division_wor;
                                        array_push($wors, $wor_new);
                                    }
                                    if ($zone_validate) {
                                        $zone_quantity = $qouta::where('quotable_id', $region->id)->where('quotable_type', 'App\Models\Region')->pluck('quantity')[0];
                                        $zone_qouta = $zone->qoutaInpercent;
                                        $qouta->training_session_id = $trainingSession->id;
                                        $zone_sum = intval($zone_quantity * $zone_qouta) * sizeof($zons);
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

                                        foreach ($wors as $keyworeda => $woreda) {
                                            if ($woreda) {
                                                $qouta = new Qouta();
                                                $woreda_validate = $qouta->where('training_session', $trainingSession->id)->where('qoutable_id', $woreda->id)->where('qoutable_type', 'App\Models\Region');
                                                if ($woreda_validate) {
                                                    $woreda_quantity = $qouta::where('quotable_id', $zone->id)->where('quotable_type', 'App\Models\Zone')->pluck('quantity')[0];
                                                    $woreda_qouta = $woreda->qoutaInpercent;
                                                    $qouta->training_session_id = $trainingSession->id;
                                                    $woreda_sum = intval($woreda_quantity * $woreda_qouta) * sizeof($wors);

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
                        }
                    } else {
                        dump('region');
                    }
                }
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
        $regions = Region::all();
        $zones = Zone::all();
        $woredas = Woreda::all();

        $sum = 0;
        $arr = [];
        foreach ($regions as $reg) {
            if ($reg->status == 0) {
                $sum+=$reg->qoutaInpercent;
            }else{
                array_push($arr, $reg);
            }
        }

        if($arr){
            $regs = [];
            $division = $sum/sizeof($arr);

            foreach ($arr as $reg_new) {
                $reg_new->qoutaInpercent = $reg_new->qoutaInpercent + $division;
                array_push($regs, $reg_new);
            }

            $trainingSession->update($data);
            $qouta_all = $qouta->all();
            foreach ($qouta_all as $key => $qou) {
                $qo = Qouta::where('training_session_id', $trainingSession->id);
                $qo->delete();
            }
            $regions = $regs;
            $reg_sum = 0;
            $check_sum_reg = 0;
            $check_sum_zon = 0;
            $check_sum_wor = 0;
            foreach ($regions as $key => $region) {
                $qouta = new Qouta();
                $region_validate = $qouta->where('training_session_id', $trainingSession->id)->where('quotable_id', $region->id)->where('quotable_type', 'App\Models\Region');

                $sum_zon = 0;
                $arr_zon = [];
                foreach ($region->zones as $zon) {
                    if ($zon->status == 0) {
                        $sum_zon+=$zon->qoutaInpercent;
                    }else{
                        array_push($arr_zon, $zon);
                    }
                }

                if ($arr_zon) {
                    $zons = [];
                    $division_zon = $sum_zon/sizeof($arr_zon);

                    foreach ($arr_zon as $zon_new) {
                        $zon_new->qoutaInpercent = $zon_new->qoutaInpercent + $division_zon;
                        array_push($zons, $zon_new);
                    }

                    if ($region_validate) {
                        $reg_qouta = $region->qoutaInpercent;
                        $qouta->training_session_id = $trainingSession->id;
                        $reg_sum = intval($request->get('quantity') * $reg_qouta) * sizeof($regions);
                        $check_reg_qua = ($request->get('quantity') - $reg_sum) - $key;
                        $check_decimal = ($request->get('quantity')*$reg_qouta) - floor($request->get('quantity')*$reg_qouta);
                        $check_sum_reg+=$check_decimal;
                        // dump($check_sum_ch);
                        if ($check_sum_reg >= 1) {
                            $qouta->quantity = intval($request->get('quantity') * $reg_qouta) + 1;
                            $check_sum_reg = $check_sum_reg - 1;
                            $region->quotas()->save($qouta);
                        } else {
                            $qouta->quantity = intval($request->get('quantity') * $reg_qouta);
                            $region->quotas()->save($qouta);
                        }

                        foreach ($zons as $keyzone => $zone) {
                            if ($zone) {
                                $qouta = new Qouta();
                                $zone_validate = $qouta->where('training_session_id', $trainingSession->id)->where('quotable_id', $zone->id)->where('quotable_type', 'App\Models\Zone');

                                $sum_wor = 0;
                                $arr_wor = [];
                                foreach ($zone->woredas as $wor) {
                                    if ($wor->status == 0) {
                                        $sum_wor+=$wor->qoutaInpercent;
                                    }else{
                                        array_push($arr_wor, $wor);
                                    }
                                }

                                if ($arr_wor) {
                                    $wors = [];
                                    $division_wor = $sum_wor/sizeof($arr_wor);

                                    foreach ($arr_wor as $wor_new) {
                                        $wor_new->qoutaInpercent = $wor_new->qoutaInpercent + $division_wor;
                                        array_push($wors, $wor_new);
                                    }

                                    if ($zone_validate) {
                                        $zone_quantity = $qouta::where('quotable_id', $region->id)->where('quotable_type', 'App\Models\Region')->pluck('quantity')[0];
                                        $zone_qouta = $zone->qoutaInpercent;
                                        $qouta->training_session_id = $trainingSession->id;
                                        $zone_sum = intval($zone_quantity * $zone_qouta) * sizeof($zons);
                                        // dump($zone_quantity*$zone_qouta);
                                        $check_zone_qua = $zone_quantity - $zone_sum;
                                        // dump($zone_quantity*$zone_qouta);

                                        $check_decimal_zon = ($zone_quantity*$zone_qouta) - floor($zone_quantity*$zone_qouta);
                                        // dump($check_decimal_zon);

                                        $check_sum_zon+=$check_decimal_zon;
        
                                        $check_zone_check = $check_zone_qua - $keyzone;

                                        // dump($zone_quantity - $zone_sum);
                                        if ($check_sum_zon >= 1) {
                                            $qouta->quantity = intval($zone_quantity * $zone_qouta) + 1;
                                            $check_sum_zon = $check_sum_zon - 1;
                                            $zone->quotas()->save($qouta);
                                        } else {
                                            $qouta->quantity = intval($zone_quantity * $zone_qouta);
                                            $zone->quotas()->save($qouta);
                                        }
                                        foreach ($wors as $keyworeda => $woreda) {
                                            if ($woreda) {
                                                $qouta = new Qouta();
                                                $woreda_validate = $qouta->where('training_session_id', $trainingSession->id)->where('quotable_id', $woreda->id)->where('quotable_type', 'App\Models\Woreda');
                                                if ($woreda_validate) {
                                                    $woreda_quantity = $qouta::where('quotable_id', $zone->id)->where('quotable_type', 'App\Models\Zone')->pluck('quantity')[0];
                                                    $woreda_qouta = $woreda->qoutaInpercent;
                                                    // dump($woreda_quantity);
                                                    $qouta->training_session_id = $trainingSession->id;
                                                    $woreda_sum = intval($woreda_quantity * $woreda_qouta) * sizeof($wors);

                                                    $check_woreda_qua = $woreda_quantity - $woreda_sum;

                                                    $check_woreda_check = $check_woreda_qua - $keyworeda;

                                                    $check_decimal_wor = ($woreda_quantity*$woreda_qouta) - floor($woreda_quantity*$woreda_qouta);
                                                    


                                                    $check_sum_wor+=$check_decimal_wor;
        
                                                    if ($check_sum_wor >= 1) {
                                                        $qouta->quantity = intval($woreda_quantity * $woreda_qouta) + 1;
                                                        $check_sum_wor = $check_sum_wor - 1;
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
                        }
                    } else {
                        dump('region');
                    }
                }
            }
            // dd('dfgfd');
            }
            $qouta_reg = Qouta::where('training_session_id',$trainingSession->id)->where('quotable_type',Region::class)->get();
            $qouta_zon = Qouta::where('training_session_id',$trainingSession->id)->where('quotable_type',Zone::class)->get();
            $qouta_wor = Qouta::where('training_session_id',$trainingSession->id)->where('quotable_type',Woreda::class)->get();
            // dd($qouta_reg);
            $regional_qouta = 0;
            $zonal_qouta = 0;
            $woredal_qoutal = 0;
            foreach ($qouta_reg as $key => $reg_qou) {
                $regional_qouta+=$reg_qou->quantity;
            }
            // dd($qouta_reg);
            if ($regional_qouta < $request->get('quantity')) {
                $qouta_reg[0]->update(['quantity', $qouta_reg[0]->quantity+=($request->get('quantity') - $regional_qouta)]);
                foreach ($qouta_zon as $key => $zon_qou) {
                    $zonal_qouta+=$zon_qou->quantity;
                }
                if ($zonal_qouta < $request->get('quantity')) {
                    $qouta_zon[0]->update(['quantity', $qouta_zon[0]->quantity+=($request->get('quantity') - $zonal_qouta)]);
                    foreach ($qouta_wor as $key => $wor_qou) {
                        $woredal_qoutal+=$wor_qou->quantity;
                    }
                    if ($woredal_qoutal < $request->get('quantity')) {
                        $qouta_wor[0]->update(['quantity', $qouta_wor[0]->quantity+=($request->get('quantity') - $woredal_qoutal)]);
                    }
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
                    $new_arr = array_slice($group, 0, $quota_woreda);
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
                    $new_arr = array_slice($group, 0, $quota_woreda);
                    foreach ($new_arr as $key => $value) {
                        array_push($accepted_arr, $value);
                    }
                }
            }

            $a = [];
            $b = [];
            $left_arr = [];
            $group_reg = [];
            $group_zon = [];

            $train_session = TrainingSession::where('id', $id)->get()[0]->quantity;

            if (sizeof($accepted_arr) > $train_session) {
                sort($accepted_arr);
                $new_slice_arr = array_slice($accepted_arr, 0, $train_session, true);
                foreach ($new_slice_arr as $key => $value) {
                    array_push($a, $value);
                }
            } else if (sizeof($accepted_arr) < $train_session) {
                sort($accepted_arr);
                foreach ($accepted_arr as $key => $value) {
                    $group_reg[$value['woreda_id']][] = $value;
                }

                foreach ($group_reg as $key => $val) {
                    $wore_quantity = Qouta::where('training_session_id', $id)->where('quotable_type',Woreda::class)->where('quotable_id',$key)->get()[0]->quantity;

                    if (sizeof($val) < $wore_quantity) {
                        foreach (Woreda::where('id',$key)->get()[0]->zone->woredas as $key => $zone) {
                            foreach ($zone->applicants as $key => $zon_app) {
                                
                                if (!in_array($zon_app, $accepted_arr)) {
                                    array_push($accepted_arr, $zon_app);
                                }
                            }
                        }
                    }
                }
                
                foreach ($accepted_arr as $key => $value) {
                    $group_zon[$value['woreda_id']][] = $value;
                }

                foreach ($group_zon as $key => $val) {
                    $wore_quantity = Qouta::where('training_session_id', $id)->where('quotable_type',Woreda::class)->where('quotable_id',$key)->get()[0]->quantity;

                    if (sizeof($val) < $wore_quantity) {
                        foreach (Woreda::where('id',$key)->get()[0]->zone->region->zones as $key => $zone) {
                            foreach ($zone->woredas as $key => $wore) {
                                foreach ($wore->applicants as $key => $wor_app) {

                                    if (!in_array($wor_app, $accepted_arr)) {
                                        array_push($accepted_arr, $wor_app);
                                    }
                                }
                            }
                        }
                    }
                }


                if (sizeof($accepted_arr) < $train_session) {
                    $no_volunteer = Volunteer::all();
                    if ($train_session <= count($no_volunteer)) {
                        $dif_arr = $train_session - sizeof($accepted_arr);
                        $merge_arr = array_diff($arr, $accepted_arr);

                        foreach ($merge_arr as $value) {
                            array_push($b, $value);
                        }
                        sort($b);
                        $new_slice_merge_arr = array_slice($b, 0, $dif_arr);
                        $merged_array = array_merge($accepted_arr, $new_slice_merge_arr);

                        foreach ($merged_array as $key => $value) {
                            array_push($a, $value);
                        }
                    }else{
                        foreach ($accepted_arr as $key => $value) {
                            array_push($a, $value);
                        }
                    }
                }

                elseif(sizeof($accepted_arr) == $train_session){
                    foreach ($accepted_arr as $key => $value) {
                        array_push($a, $value);
                    }
                }else{
                    sort($accepted_arr);
                    $new_slice_arr = array_slice($accepted_arr, 0, $train_session);
                    foreach ($new_slice_arr as $key => $value) {
                        array_push($a, $value);
                    }
                }

                // foreach ($variable as $key => $value) {
                //     # code...
                // }

                foreach ($accepted_arr as $key => $value) {
                    array_push($a, $value);
                }
            } else {
                foreach ($accepted_arr as $key => $value) {
                    array_push($a, $accepted_arr);
                }
            }
            dd($a);
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
