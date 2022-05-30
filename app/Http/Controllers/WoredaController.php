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

class WoredaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Woreda::class, 'woreda');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trainingSession_id = TrainingSession::availableSession()[0]->id;
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
        $woredaInquota = $request->get('woreda_quota') / 100;
        // $woreda = new Woreda();
        $request->validate(['name' => 'required|string|unique:woredas,name', 'code' => 'required|string|unique:woredas,code']);
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
        $woreda->delete();
        // if ($request->ajax()) {
        //     return response()->json(array('msg' => 'deleted successfully'), 200);
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
        $sum = $request->qouta / 100;
        foreach ($wor as $key => $value) {
            $sum += $value->qoutaInpercent;
        }

        if ($sum <= 1) {
            $limit = true;
        }

        return response()->json(['limit' => $limit]);
    }

    public function woredaIntake(TrainingSession $trainingSession, $woreda_id)
    {
        $today = Carbon::today();
        $curr_sess = TrainingSession::where('start_date', '<=', $today)->where('end_date', '>=', $today)->get();
        $intake_exist = WoredaIntake::where('training_session_id', $trainingSession->id)->where('woreda_id', $woreda_id)->get();
        $woreda = Woreda::where('id', $woreda_id)?->get()[0];
        return view('woreda.woreda_capacity', compact('woreda', 'trainingSession', 'intake_exist', 'curr_sess'));
    }

    public function woredaIntakeStore(Request $request, TrainingSession $trainingSession, $woreda_id)
    {
        WoredaIntake::create(['training_session_id' => $trainingSession->id, 'woreda_id' => $woreda_id, 'intake' => $request->get('capacity')]);
        return redirect()->route('session.woreda.intake', ['training_session' => $trainingSession->id, 'woreda_id' => $woreda_id])->with('message', 'Woreda Intake created successfully');
    }

    public function import()
    {
        $binWoredas =ImporterFiles::WOREDA_IMPORTS;
        $woredas = [];
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

                Woreda::where('name', $woredaName)->firstOr(function () use ($woredaName, $zo) {
                    Woreda::create(['name' => $woredaName, 'status' => 1, 'zone_id' => $zo->id]);
                });
            }
        }
        // dd('Woreda Imported successfully');
    }
}
