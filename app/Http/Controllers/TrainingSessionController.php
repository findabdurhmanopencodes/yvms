<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Constants;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\ApprovedApplicant;
use App\Models\CindicationRoom;
use App\Models\Qouta;
use App\Models\Region;
use App\Models\Resource;
use App\Models\Status;
use App\Models\Training;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\TrainingSessionTraining;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Woreda;
use App\Models\Zone;
use Carbon\Carbon;
use Database\Seeders\PermissionSeeder;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use League\CommonMark\Extension\SmartPunct\Quote;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TrainingSessionController extends Controller
{

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    // protected function resourceAbilityMap()
    // {

    //     return [
    //         'show' => 'view',
    //         'create' => 'create',
    //         'store' => 'create',
    //         'edit' => 'update',
    //         'update' => 'update',
    //         'destroy' => 'delete',
    //         'trainingCenterIndex' => 'trainingCenterIndex',
    //     ];
    // }

    // /**
    //  * Get the list of resource methods which do not have model parameters.
    //  *
    //  * @return array
    //  */
    // protected function resourceMethodsWithoutModels()
    // {
    //     return ['index', 'create', 'store','trainingCenterIndex'];
    // }

    public function __construct()
    {
        // $this->authorizeResource(TrainingSession::class, 'trainingSession');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(TrainingSession::select())->addColumn('start_date_et', function (TrainingSession $trainingSession) {
                return $trainingSession->startDateET();
            })->addColumn('end_date_et', function (TrainingSession $trainingSession) {
                return $trainingSession->endDateET();
            })->addColumn('start_reg_date_et', function (TrainingSession $trainingSession) {
                return $trainingSession->startRegDateET();
            })->addColumn('reg_end_date_et', function (TrainingSession $trainingSession) {
                return $trainingSession->endRegDateET();
            })->make(true);
        }

        $date_now = Carbon::now();
        $check_date = false;

        $training_sessions = TrainingSession::all();

        if ($training_sessions) {
            foreach ($training_sessions as $training_session) {
                if ((new DateTime($training_session->start_date) <= new DateTime($date_now->format('Y-m-d'))) && (new DateTime($date_now->format('Y-m-d')) <= new DateTime($training_session->end_date))) {
                    $check_date = true;
                }
            }
        }

        $training_session = TrainingSession::all();
        $regions = Region::all();
        return view('training_session.index', compact(['training_session', 'regions', 'check_date']));
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
        // new DateTime($training_session->end_date) <= new DateTime($date_now->format('Y-m-d'))
        if ($training_sessions) {
            foreach ($training_sessions as $training_session) {
                if ((new DateTime($training_session->start_date) <= new DateTime($date_now->format('Y-m-d'))) && (new DateTime($date_now->format('Y-m-d')) <= new DateTime($training_session->end_date))) {
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
        $date_now_et = DateTimeFactory::fromDateTime($date_now)->format('d/m/Y');

        $request->validate([
            'name' => 'required',
            'start_date' => ['date_format:d/m/Y', 'after:' . $date_now_et],
            'end_date' => ['date_format:d/m/Y', 'after_or_equal:start_date'],
            'registration_start_date' => ['required', 'date_format:d/m/Y', 'after_or_equal:start_date', 'before_or_equal:end_date'],
            'registration_dead_line' => ['required', 'date_format:d/m/Y', 'after_or_equal:registration_start_date', 'before_or_equal:end_date'],
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

        $end_date_am = $trainingSession->endDateET();

        $trainingSession->update(['end_date_am' => $end_date_am]);

        foreach (Status::where('acceptance_status', 1)->get() as $key => $stat) {
            Volunteer::where('id', $stat->volunteer_id)->update(['training_session_id' => $trainingSession->id]);
        }

        $regions = Region::all();
        $sum = 0;
        $arr = [];
        foreach ($regions as $reg) {
            if ($reg->status == 0) {
                $sum += $reg->qoutaInpercent;
            } else {
                array_push($arr, $reg);
            }
        }

        if ($arr) {
            $regs = [];
            $division = $sum / sizeof($arr);

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
                        $sum_zon += $zon->qoutaInpercent;
                    } else {
                        array_push($arr_zon, $zon);
                    }
                }

                if ($arr_zon) {
                    $zons = [];
                    $division_zon = $sum_zon / sizeof($arr_zon);

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
                                        $sum_wor += $wor->qoutaInpercent;
                                    } else {
                                        array_push($arr_wor, $wor);
                                    }
                                }
                                if ($arr_wor) {
                                    $wors = [];
                                    $division_wor = $sum_wor / sizeof($arr_wor);

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
        // dd($training_session->start_date->format('d/m/y'));
        $start_date = DateTimeFactory::fromDateTime(new DateTime($training_session->start_date))->format('d/m/Y');
        $end_date = DateTimeFactory::fromDateTime(new DateTime($training_session->end_date))->format('d/m/Y');
        $registration_start_date = DateTimeFactory::fromDateTime(new DateTime($training_session->registration_start_date))->format('d/m/Y');
        $registration_dead_line = DateTimeFactory::fromDateTime(new DateTime($training_session->registration_dead_line))->format('d/m/Y');

        $data = [$start_date, $end_date, $registration_start_date, $registration_dead_line];

        return view('training_session.create', compact('training_session', 'data'));
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
        $date_now_et = DateTimeFactory::fromDateTime($trainingSession->start_date)->format('d/m/Y');

        $data = $request->validate([
            'name' => 'required',
            'start_date' => ['date_format:d/m/Y', 'after_or_equal:' . $date_now_et],
            'end_date' => ['date_format:d/m/Y', 'after_or_equal:start_date'],
            'registration_start_date' => ['required', 'date_format:d/m/Y', 'after_or_equal:start_date', 'before_or_equal:end_date'],
            'registration_dead_line' => ['required', 'date_format:d/m/Y', 'after_or_equal:registration_start_date', 'before_or_equal:end_date'],
            'quantity' => 'required'
        ]);

        $end_date_am = $trainingSession->endDateET();

        $trainingSession->update(['end_date_am' => $end_date_am]);

        $regions = Region::all();
        $zones = Zone::all();
        $woredas = Woreda::all();

        $sum = 0;
        $arr = [];
        foreach ($regions as $reg) {
            if ($reg->status == 0) {
                $sum += $reg->qoutaInpercent;
            } else {
                array_push($arr, $reg);
            }
        }

        if ($arr) {
            $regs = [];
            $division = $sum / sizeof($arr);

            foreach ($arr as $reg_new) {
                $reg_new->qoutaInpercent = $reg_new->qoutaInpercent + $division;
                array_push($regs, $reg_new);
            }

            $date_start_gc =  DateTime::createFromFormat('d/m/Y', $data['start_date']);
            $date_end_gc =  DateTime::createFromFormat('d/m/Y', $data['end_date']);
            $date_start_reg_gc =  DateTime::createFromFormat('d/m/Y', $data['registration_start_date']);
            $date_end_reg_gc =  DateTime::createFromFormat('d/m/Y', $data['registration_dead_line']);

            $d_s_t_g = DateTimeFactory::of($date_start_gc->format('Y'), $date_start_gc->format('m'), $date_start_gc->format('d'))->toGregorian();

            $d_e_t_g = DateTimeFactory::of($date_end_gc->format('Y'), $date_end_gc->format('m'), $date_end_gc->format('d'))->toGregorian();

            $d_r_s_t_g = DateTimeFactory::of($date_start_reg_gc->format('Y'), $date_start_reg_gc->format('m'), $date_start_reg_gc->format('d'))->toGregorian();

            $d_r_d_t_g = DateTimeFactory::of($date_end_reg_gc->format('Y'), $date_end_reg_gc->format('m'), $date_end_reg_gc->format('d'))->toGregorian();

            $trainingSession->update(['moto' => $data['name'], 'start_date' => $d_s_t_g, 'end_date' => $d_e_t_g, 'registration_start_date' => $d_r_s_t_g, 'registration_dead_line' => $d_r_d_t_g, 'quantity' => $data['quantity']]);

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
                        $sum_zon += $zon->qoutaInpercent;
                    } else {
                        array_push($arr_zon, $zon);
                    }
                }

                if ($arr_zon) {
                    $zons = [];
                    $division_zon = $sum_zon / sizeof($arr_zon);

                    foreach ($arr_zon as $zon_new) {
                        $zon_new->qoutaInpercent = $zon_new->qoutaInpercent + $division_zon;
                        array_push($zons, $zon_new);
                    }

                    if ($region_validate) {
                        $reg_qouta = $region->qoutaInpercent;
                        $qouta->training_session_id = $trainingSession->id;
                        $reg_sum = intval($request->get('quantity') * $reg_qouta) * sizeof($regions);
                        $check_reg_qua = ($request->get('quantity') - $reg_sum) - $key;
                        $check_decimal = ($request->get('quantity') * $reg_qouta) - floor($request->get('quantity') * $reg_qouta);
                        $check_sum_reg += $check_decimal;
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
                                        $sum_wor += $wor->qoutaInpercent;
                                    } else {
                                        array_push($arr_wor, $wor);
                                    }
                                }

                                if ($arr_wor) {
                                    $wors = [];
                                    $division_wor = $sum_wor / sizeof($arr_wor);

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

                                        $check_decimal_zon = ($zone_quantity * $zone_qouta) - floor($zone_quantity * $zone_qouta);
                                        // dump($check_decimal_zon);

                                        $check_sum_zon += $check_decimal_zon;

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

                                                    $check_decimal_wor = ($woreda_quantity * $woreda_qouta) - floor($woreda_quantity * $woreda_qouta);



                                                    $check_sum_wor += $check_decimal_wor;

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
        $qouta_reg = Qouta::where('training_session_id', $trainingSession->id)->where('quotable_type', Region::class)->get();
        $qouta_zon = Qouta::where('training_session_id', $trainingSession->id)->where('quotable_type', Zone::class)->get();
        $qouta_wor = Qouta::where('training_session_id', $trainingSession->id)->where('quotable_type', Woreda::class)->get();
        // dd($qouta_reg);
        $regional_qouta = 0;
        $zonal_qouta = 0;
        $woredal_qoutal = 0;
        foreach ($qouta_reg as $key => $reg_qou) {
            $regional_qouta += $reg_qou->quantity;
        }
        // dd($qouta_reg);
        if ($regional_qouta < $request->get('quantity')) {
            $qouta_reg[0]->update(['quantity', $qouta_reg[0]->quantity += ($request->get('quantity') - $regional_qouta)]);
            foreach ($qouta_zon as $key => $zon_qou) {
                $zonal_qouta += $zon_qou->quantity;
            }
            if ($zonal_qouta < $request->get('quantity')) {
                $qouta_zon[0]->update(['quantity', $qouta_zon[0]->quantity += ($request->get('quantity') - $zonal_qouta)]);
                foreach ($qouta_wor as $key => $wor_qou) {
                    $woredal_qoutal += $wor_qou->quantity;
                }
                if ($woredal_qoutal < $request->get('quantity')) {
                    $qouta_wor[0]->update(['quantity', $qouta_wor[0]->quantity += ($request->get('quantity') - $woredal_qoutal)]);
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
        // dd($status_table);
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
            $final_arr = [];
            $group_zon = [];

            $train_session = TrainingSession::where('id', $id)->get()[0]->quantity;
            $merge_arr = array_diff($arr, $accepted_arr);

            if (count($accepted_arr) < $train_session) {
                foreach ($accepted_arr as $key => $acc) {
                    array_push($left_arr, $acc->woreda->zone->region->id);
                }

                foreach (array_count_values($left_arr) as $key_co => $count) {
                    $gr_reg = [];
                    $count_diff = 0;
                    foreach (Qouta::where('training_session_id', $id)->where('quotable_type', Region::class)->get() as $key => $reg_quota) {
                        if ($reg_quota->quotable->id == $key_co) {
                            if ($count < $reg_quota->quantity) {
                                foreach ($merge_arr as $key => $val) {
                                    if ($val->woreda->zone->region->id == $reg_quota->quotable_id) {
                                        if (!in_array($val, $accepted_arr)) {
                                            array_push($gr_reg, $val);
                                            $count_diff = $reg_quota->quantity - $count;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // dump($count_diff);
                    sort($gr_reg);
                    $new_slice_arr = array_slice($gr_reg, 0, $count_diff);
                    array_push($group_reg, $new_slice_arr);
                }

                foreach ($group_reg as $key => $gr) {
                    foreach ($gr as $key => $sub_gr) {
                        array_push($accepted_arr, $sub_gr);
                    }
                }
                $b = [];
                $volunteer_count = count(Volunteer::all());
                if (count($accepted_arr) < $train_session && count($accepted_arr) < $volunteer_count) {
                    // dd($accepted_arr);
                    $dif_arr = $train_session - count($accepted_arr);

                    $merge_acc = array_diff($arr, $accepted_arr);
                    foreach ($merge_acc as $acc) {
                        array_push($b, $acc);
                    }
                    sort($b);
                    $new_slice_merge_arr = array_slice($b, 0, $dif_arr);
                    $merged_array = array_merge($accepted_arr, $new_slice_merge_arr);
                    $accepted_arr = [];
                    foreach ($merged_array as $key => $value) {
                        array_push($accepted_arr, $value);
                    }
                } elseif (count($accepted_arr) > $train_session) {
                    sort($accepted_arr);
                    $new_slice_arr = array_slice($accepted_arr, 0, $train_session);
                    foreach ($new_slice_arr as $key => $value) {
                        array_push($accepted_arr, $value);
                    }
                }
            }
            $approved_applicants = ApprovedApplicant::where('training_session_id', $id)->delete();

            foreach ($accepted_arr as $key => $accepted) {
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
        return redirect()->route('session.applicant.verified', ['training_session' => $id])->with('message', 'Applicant approved successfully');
    }
    public function resetScreen($training_session_id)
    {

        if (count(TrainingPlacement::where(['training_session_id' => request()->route('training_session')])->get()) > 0) {

            return redirect()->back()->withErrors('Reseting Screening Is Not Allowed Because Training Placement is Already Done!!  Reset Training Placement To do this Task ');
        } else {
            foreach (Volunteer::whereRelation('approvedApplicant', 'training_session_id', $training_session_id)->get() as $volunteer) {
                foreach (Status::all() as $status) {
                    if ($volunteer->id == $status->volunteer_id) {
                        Status::find($status->id)->update(['acceptance_status' => 1]);
                    }
                }
            }
            ApprovedApplicant::where('training_session_id', $training_session_id)->delete();
        }
        return redirect()->back();
    }

    public function screenManually(Request $request, $session_id, $applicant_id)
    {
        $woreda = Volunteer::where('id', $applicant_id)->get()[0]->woreda;
        $zone = $woreda->zone;
        $region = $zone->region;

        $session_amount = TrainingSession::where('id', $session_id)->get()[0]->quantity;
        $approved_amount = ApprovedApplicant::all();
        $del_stack = [];
        $approved_stack = [];

        if (count($approved_amount) == $session_amount) {
            foreach (ApprovedApplicant::where('training_session_id', $session_id)->get() as $key => $approved) {
                if ($woreda->id == $approved->volunteer->woreda->id) {
                    array_push($approved_stack, $approved->volunteer);
                }
            }

            if ($approved_stack) {
                foreach ($approved_stack as $key => $app) {
                    array_push($del_stack, $app);
                }
            } else {
                foreach (ApprovedApplicant::where('training_session_id', $session_id)->get() as $key => $approved) {
                    if ($zone->id == $approved->volunteer->woreda->zone->id) {
                        array_push($approved_stack, $approved->volunteer);
                    }
                }
                if ($approved_stack) {
                    foreach ($approved_stack as $key => $app) {
                        array_push($del_stack, $app);
                    }
                } else {
                    foreach (ApprovedApplicant::where('training_session_id', $session_id)->get() as $key => $approved) {
                        if ($region->id == $approved->volunteer->woreda->zone->region->id) {
                            array_push($approved_stack, $approved->volunteer);
                        }
                    }
                    if ($approved_stack) {
                        foreach ($approved_stack as $key => $app) {
                            array_push($del_stack, $app);
                        }
                    } else {
                        foreach (ApprovedApplicant::where('training_session_id', $session_id)->get() as $key => $approved) {
                            array_push($del_stack, $approved);
                        }
                    }
                }
            }

            sort($del_stack);
            // dd($del_stack);

            foreach ($del_stack as $del) {
                $del_val = ApprovedApplicant::where('volunteer_id', $del->id)->get()[0];
            }

            $del_val->delete();
            ApprovedApplicant::create(['training_session_id' => $session_id, 'volunteer_id' => $applicant_id, 'status' => 1]);
            Status::where('volunteer_id', $applicant_id)->get()[0]->update(['acceptance_status' => 3]);
        } elseif (count($approved_amount) < $session_amount) {
            ApprovedApplicant::create(['training_session_id' => $session_id, 'volunteer_id' => $applicant_id, 'status' => 1]);
            Status::where('volunteer_id', $applicant_id)->get()[0]->update(['acceptance_status' => 3]);
        }

        return redirect()->route('session.applicant.verified', ['training_session' => $session_id])->with('message', 'Applicant approved successfully');
    }

    public function applicantInfo(Request $request, Volunteer $volunteer)
    {
        $applicant = Volunteer::where('training_session_id', $request->training_session_id)->where('id', $request->applicant_id)->get()[0];

        $applicant_region = $applicant->woreda->zone->region->name;
        return response()->json(['applicant' => $applicant, 'applicant_woreda' => $applicant_region]);
    }


    public function setSchedule(Request $request, TrainingSession $trainingSession)
    {
        $data = $request->validate([
            'training_start_date' => ['required'],
            'training_end_date' => ['required',]
        ]);
        $date =  DateTime::createFromFormat('d/m/Y', $request->get('training_start_date'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $scheduleStartDate = DateTimeFactory::of($year, $month, $day)->toGregorian();

        $date =  DateTime::createFromFormat('d/m/Y', $request->get('training_end_date'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $scheduleEndDate = DateTimeFactory::of($year, $month, $day)->toGregorian();

        $sessionStartDate = $trainingSession->start_date;
        $sessionEndDate = $trainingSession->end_date;
        if ($scheduleStartDate < Carbon::today()) {
            throw ValidationException::withMessages(['training_start_date' => 'Please make sure start date is after today']);
        }
        if ($scheduleStartDate > $scheduleEndDate) {
            throw ValidationException::withMessages(['training_start_date' => 'Please make sure start date is correct']);
        }
        if ($scheduleEndDate > $sessionEndDate) {
            throw ValidationException::withMessages(['training_end_date' => 'Please make sure end date is before Training session date']);
        }
        $data['training_start_date'] = $scheduleStartDate;
        $data['training_end_date'] = $scheduleEndDate;
        $trainingSession->update($data);
        return redirect()->back()->with('message', 'Schedule created successfully!');
    }
    public function trainings(TrainingSession $trainingSession)
    {
        $trainingSchedules = $trainingSession->trainingScheduless;
        $trainings = [];
        $trainingIds = [];
        foreach ($trainingSchedules as $ts) {
            if (!in_array($ts->training->id, $trainingIds)) {
                array_push($trainings, $ts->training);
                array_push($trainingIds, $ts->training->id);
            }
        }
        return view('training_session.training', compact('trainings'));
    }

    public function trainingCenterIndex(TrainingSession $trainingSession)
    {
        // $user = Auth::user();
        // if($user->can('session.detail.based')){
        //     dd('sd');
        //     // $center = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('user_id',$user->id)->where('permission_id',);
        //     dd($center->get());
        //     dd('sd');
        //     // $trainingCenterCapacities = TrainingCenterCapacity::where('training_session_id', $trainingSession->id)->whereIn('trainining_center_id',)->get();
        // }
        // else{
            $trainingCenterCapacities = TrainingCenterCapacity::where('training_session_id', $trainingSession->id)->get();
        // }

        return view('training_session.centers', compact('trainingSession', 'trainingCenterCapacities'));
    }

    public function trainingCenterShow(TrainingSession $trainingSession, TraininingCenter $trainingCenter)
    {
        $cindicationRooms = CindicationRoom::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->get();
        $miniSide = 'aside-minimize';
        $volunteers = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingCenter->id)->get();
        $checkedInVolunteers = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingCenter->id)->whereRelation('status', 'acceptance_status', 5)->get();
        $totalVolunteers = count($volunteers);
        $totalTrainingMasters = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->count();
        $trainings = Training::whereIn('id', TrainingSessionTraining::where('training_session_id', $trainingSession->id)->pluck('id'))->get();
        $coordinatorPermission = Permission::findOrCreate(PermissionSeeder::CENTER_COORIDNATOR);
        $centerCoordinatorQuery = User::whereIn('id', TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->where('permission_id', $coordinatorPermission->id)->pluck('user_id'));
        $centerCoordinators = $centerCoordinatorQuery->get();
        $centerCoordinatorUsers =  User::doesntHave('volunteer')->doesntHave('trainner')->permission($coordinatorPermission->id)->whereNotIn('id', $centerCoordinatorQuery->pluck('id'))->get();
        $freeTrainners = TrainingMaster::all();
        $checkerPermission = Permission::findOrCreate('checker');
        $centerCheckerQuery = User::whereIn('id', TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->where('permission_id', $checkerPermission->id)->pluck('user_id'));
        $centerCheckers = $centerCheckerQuery->get();
        Permission::findOrCreate('checker');
        $checkerUsers = User::doesntHave('volunteer')->doesntHave('trainner')->permission('checker')->whereNotIn('id', $centerCheckerQuery->pluck('id'))->get();
        return view('training_session.center_show', compact('centerCoordinators', 'centerCoordinatorUsers', 'checkedInVolunteers', 'centerCheckers', 'checkerUsers', 'freeTrainners', 'trainings', 'trainingSession', 'totalTrainingMasters', 'totalVolunteers', 'trainingCenter', 'miniSide', 'cindicationRooms'));
    }
    public function resourceAssignToTrainingCenter($training_session, Request $request)
    {
        $training_center_id = $request->get('training_center_id');
        $resource_id = $request->get('resource_id');
        $amount = $request->get('amount');
        $trainingCenter = TraininingCenter::find($training_center_id);
        $trainingCenter->resources()->attach($resource_id, ['current_balance' => $amount, 'initial_balance' => $amount, 'training_session_id' => $training_session]);
        return redirect()->back()->with('msg', 'Resource Added Sucessfuily TO Training Center');
    }
    public function updateResourceAssignToTrainingCenter($training_session, Request $request)
    {
        // dd($request);

        $training_center_id = $request->get('training_center_id');
        $resource_id = $request->get('resource_id');
        $amount = $request->get('amount');
        $trainingCenter = TraininingCenter::find($training_center_id);
        $trainingCenterResourceCurrentBalance = $trainingCenter->resources()->latest()->first()->pivot->current_balance;
        DB::table('resource_trainining')->where('resource_id', $resource_id)->where('training_session_id', $training_center_id)->where('trainining_center_id', $training_center_id)->update([
            'current_balance' => $trainingCenterResourceCurrentBalance + $amount
        ]);

        $trainingCenter->resources()->attach($resource_id, ['current_balance' => (int)$amount + $trainingCenterResourceCurrentBalance, 'initial_balance' => $amount, 'training_session_id' => $training_session]);

        return redirect()->back()->with('msg', 'Resource Added Sucessfuily TO Training Center');
    }
    public function showResource($training_session, $resource)
    {


        return view('training_session.resource.show', ['resource' => Resource::find($resource), 'trainingCenters' => TraininingCenter::all()]);
    }
    public function allResource()
    {
        return view('training_session.resource.index', ['resources' => Resource::all()]);
        return view('training_session.resource.index', ['resources' => Resource::paginate(10)]);
    }

    public function approvePlacment(TrainingSession $trainingSession)
    {
        $trainingSession->update(['status' => Constants::TRAINING_SESSION_PLACEMENT_APPROVE]);
        $trainingSession->save();
        Artisan::call('id:generate');
        return redirect()->back()->with('message', 'Placment approved successfully');
    }
}
