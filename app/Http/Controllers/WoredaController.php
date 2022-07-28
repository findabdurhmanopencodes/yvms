<?php

namespace App\Http\Controllers;

use App\Models\Woreda;
use App\Http\Requests\StoreWoredaRequest;
use App\Http\Requests\UpdateWoredaRequest;
use App\ImporterFiles;
use App\Models\TrainingSession;
use App\Models\WoredaIntake;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WoredaController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Woreda::class, 'woreda');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Woreda.index')) {
            return abort(403);
        }
        $trainingSession_id = TrainingSession::availableSession()?->first()?->id;
        if ($request->ajax()) {
            return datatables()->of(Woreda::select())->addColumn('zone', function (Woreda $woreda) {
                return $woreda->zone->name;
            })->make(true);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        $woredas = Woreda::all();
        $zones = Zone::all();
        return view('woreda.index', compact(['zones', 'woredas', 'trainingSession_id']));
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
     * @param  \App\Http\Requests\StoreWoredaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWoredaRequest $request)
    {
        if (!Auth::user()->can('Woreda.store')) {
            return abort(403);
        }
        $woredaInquota = $request->get('woreda_quota') / 100;
        // $woreda = new Woreda();
        $request->validate(['name' => 'required|string|unique:woredas,name', 'code' => 'required|string|unique:woredas,code', 'woreda_quota'=>'required|numeric|min:0|not_in:0']);
        // $zone->name = $request->get('name');
        // $zone->code = $request->get('code');
        // $zone->region_id = $request->get('region');
        // $zone->save();
        Woreda::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'zone_id' => $request->get('woreda'), 'qoutaInpercent' => $woredaInquota, 'status' => 1]);
        return redirect()->route('woreda.index')->with('message', 'Woreda created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function show(Woreda $woreda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (!Auth::user()->can('Woreda.update')) {
            return abort(403);
        }
        $woreda = Woreda::find($id);
        // dd($zone->region->name);
        $zones = Zone::where('id', '!=', $woreda->zone->id)->get();
        return view('woreda.edit', compact(['woreda', 'zones']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWoredaRequest  $request
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWoredaRequest $request, $id)
    {
        if (!Auth::user()->can('Woreda.update')) {
            return abort(403);
        }
        $woreda = Woreda::find($id);
        $woreda->name = $request->get('name');
        $woreda->code = $request->get('code');
        $woreda->zone_id = $request->get('zone');
        $woreda->qoutaInpercent = $request->get('qoutaInpercent') / 100;
        $woreda->status = 1;
        if ($request->get('status')) {
            if ($request->get('status') == 'on') {
                $woreda->status = 1;
            } else {
                $woreda->status = 0;
            }
        } else {
            $woreda->status = 0;
        }
        // dd($woreda->qoutaInpercent);
        $woreda->save();
        return redirect()->route('woreda.index')->with('message', 'Woreda edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Woreda $woreda, Request $request)
    {
        if (!Auth::user()->can('Woreda.destroy')) {
            return abort(403);
        }
        // dd($woreda);
        $woreda->delete();
        // if ($request->ajax()) {
        return response()->json(array('msg' => 'deleted successfully'), 200);
        // }
    }
    public function fetch(Zone $zone)
    {
        return datatables()->of(Woreda::select()->where('zone_id', '=', $zone->id))->make(true);
    }

    public function validateForm(Woreda $woreda, Request $request)
    {
        $limit = false;
        $wor = $woreda::where('zone_id', $request->zone_id)->get();
        $sum = $request->qouta;
        foreach ($wor as $key => $value) {
            $a = $value->qoutaInpercent * 100;
            $sum += $a;
        }

        $sum = ($sum - $request->prv_val)/100;

        if ($sum <= 1) {
            $limit = true;
        }

        return response()->json(['limit' => $limit]);
    }

    public function woredaIntake(TrainingSession $trainingSession, $woreda_id)
    {
        if (!Auth::user()->can('WoredaIntake.index')) {
            return abort(403);
        }
        $today = Carbon::today();
        $curr_sess = TrainingSession::where('start_date', '<=', $today)->where('end_date', '>=', $today)->get();
        $intake_exist = WoredaIntake::where('training_session_id', $trainingSession->id)->where('woreda_id', $woreda_id)->get();
        $zone = Woreda::where('id',$woreda_id)->get()->first()->zone;
        $woredaAllIntake = 0;
        foreach (Woreda::where('status',1)->get() as $key => $value) {
            // $zoneAllIntake
            $zone_this = Woreda::where('id',$value->id)->get()->first()->zone;
            if (($zone_this == $zone) && ($value->woredaIntakes->where('training_session_id',$trainingSession->id)->last())) {
                $woredaAllIntake+=$value->woredaIntakes->where('training_session_id',$trainingSession->id)->last()->intake;
            }
        }
        if ($zone->zoneIntakes->last()) {
            $woredaAllIntake = $zone->zoneIntakes?->where('training_session_id',$trainingSession->id)->last()->intake - $woredaAllIntake;
            $woreda = Woreda::where('id', $woreda_id)?->get()[0];
            return view('woreda.woreda_capacity', compact('woreda', 'trainingSession', 'intake_exist', 'curr_sess', 'woredaAllIntake'));
        }else{
            return redirect()->route('woreda.index')->with('error', 'Specify Zone First!!');
        }
    }

    public function woredaIntakeStore(Request $request, TrainingSession $trainingSession, $woreda_id)
    {
        if (!Auth::user()->can('WoredaIntake.store')) {
            return abort(403);
        }
        WoredaIntake::create(['training_session_id' => $trainingSession->id, 'woreda_id' => $woreda_id, 'intake' => $request->get('capacity')]);
        return redirect()->route('session.woreda.intake', ['training_session' => $trainingSession->id, 'woreda_id' => $woreda_id])->with('message', 'Woreda Intake created successfully');
    }
    public function woredaIntakeEdit(TrainingSession $trainingSession, $woreda_id){
        if (!Auth::user()->can('WoredaIntake.update')) {
            return abort(403);
        }
        $woredas = Woreda::find($woreda_id);
        $woredaIntake = $woredas->woredaIntakes->where('training_session_id', $trainingSession->id)->last();
        $zone = Woreda::where('id',$woreda_id)->get()->first()->zone;
        $woredaAllIntake = 0;
        foreach (Woreda::where('status',1)->get() as $key => $value) {
            // $zoneAllIntake
            $zone_this = Woreda::where('id',$value->id)->get()->first()->zone;
            if (($zone_this == $zone) && ($value->woredaIntakes->where('training_session_id',$trainingSession->id)->last())) {
                $woredaAllIntake+=$value->woredaIntakes->where('training_session_id',$trainingSession->id)->last()->intake;
            }
        }
        $woredaAllIntake = ($zone->zoneIntakes?->where('training_session_id',$trainingSession->id)->last()->intake - $woredaAllIntake) + $woredaIntake->intake;

        return view('woreda.woredaIntake', compact('woredaIntake', 'woredas', 'trainingSession', 'woredaAllIntake'));
    }
    public function woredaIntakeUpdate(Request $request, TrainingSession $trainingSession, $woreda_id){
        if (!Auth::user()->can('WoredaIntake.update')) {
            return abort(403);
        }
        $woredas = Woreda::find($woreda_id);
        $woredaIntake = $woredas->woredaIntakes->where('training_session_id',$trainingSession->id)->last();
        $woredaIntake->intake = $request->get('capacity');
        $woredaIntake->save();
        return redirect()->route('session.woreda.intake', ['training_session' => $trainingSession->id, 'woreda_id' => $woreda_id])->with('message', 'Woreda Intake updated successfully');
    }

    public function import()
    {
        dd('none');
        $binWoredas =ImporterFiles::WOREDA_IMPORTS;
        $woredas = [];
        $totalWoredas = 0;
        $zone = null;
        foreach ($binWoredas as $bin) {
            if ($bin[0] != null) {
                $zone = $bin[0];
            }
            $woredaName = $bin[1];
            if ($woredaName == null) {
                dump($zone . ' - null found');
            } else {
                $zo = Zone::where('name', $zone)->first();
                Woreda::where('name', $woredaName)->firstOr(function () use ($woredaName, $zo,&$totalWoredas) {
                    Woreda::create(['name' => $woredaName, 'status' => 1, 'zone_id' => $zo->id]);
                    $totalWoredas++;
                });
            }
        }
        dump($totalWoredas.' Woreda Imported successfully');
    }
}
