<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\Woreda;
use App\Models\ZoneIntake;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Zone::class, 'zone');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region, Request $request)
    {
        $trainingSession_id = TrainingSession::availableSession()[0]->id;
        if ($request->ajax()) {
            return datatables()->of(Zone::select())->addColumn('region', function (Zone $zone) {
                return $zone->region->name;
            })->make(true);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        $zones = Zone::all();
        $regions = Region::all();
        return view('zone.index', compact(['zones', 'regions', 'trainingSession_id']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Region $region)
    {
        $regions = $region::all();
        return view('zone.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreZoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZoneRequest $request)
    {
        $zoneInquota = $request->get('zone_quota') / 100;
        $zone = new Zone();
        $request->validate(['name' => 'required|string|unique:zones,name', 'code' => 'required|string|unique:zones,code']);
        // $zone->name = $request->get('name');
        // $zone->code = $request->get('code');
        // $zone->region_id = $request->get('region');
        // $zone->save();
        Zone::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'region_id' => $request->get('region'), 'qoutaInpercent' => $zoneInquota, 'status' => 1]);
        return redirect()->route('zone.index')->with('message', 'Zone created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $zone = Zone::find($id);
        // dd($zone->region->name);
        $regions = Region::where('id', '!=', $zone->region->id)->get();
        return view('zone.edit', compact(['zone', 'regions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateZoneRequest  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZoneRequest $request, $id)
    {
        $zone = Zone::find($id);
        $zone->name = $request->get('name');
        $zone->code = $request->get('code');
        $zone->region_id = $request->get('region');
        $zone->qoutaInpercent = $request->get('qoutaInpercent') / 100;
        if ($request->get('status')) {
            if ($request->get('status') == 'on') {
                $zone->status = 1;
            } else {
                $zone->status = 0;
                foreach ($zone->woredas as $key => $wor) {
                    $woreda = Woreda::find($wor->id);
                    $woreda->status = 0;
                    $woreda->save();
                }
            }
        } else {
            $zone->status = 0;
            foreach ($zone->woredas as $key => $wor) {
                $woreda = Woreda::find($wor->id);
                $woreda->status = 0;
                $woreda->save();
            }
        }
        $zone->save();
        return redirect()->route('zone.index')->with('message', 'Zone edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone, Request $request)
    {
        // foreach ($zone->woredas as $woreda) {
        //     $woreda->delete();
        // }
        $zone->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
    public function fetch(Region $region)
    {
        return datatables()->of(Zone::select()->where('region_id', '=', $region->id))->make(true);
    }

    public function validateForm(Zone $zone, Request $request)
    {
        $limit = false;
        $zon = $zone::where('region_id', $request->region_id)->get();
        $sum = $request->qouta / 100;
        foreach ($zon as $key => $value) {
            $sum += $value->qoutaInpercent;
        }

        if ($sum <= 1) {
            $limit = true;
        }

        return response()->json(['limit' => $limit]);
    }

    public function zoneIntake(TrainingSession $trainingSession, $zone_id)
    {
        $today = Carbon::today();
        $curr_sess = TrainingSession::where('start_date', '<=', $today)->where('end_date', '>=', $today)->get();
        $intake_exist = ZoneIntake::where('training_session_id', $trainingSession->id)->where('zone_id', $zone_id)->get();
        $zone = Zone::where('id', $zone_id)?->get()[0];
        return view('zone.zone_capacity', compact('zone', 'trainingSession', 'intake_exist', 'curr_sess'));
    }

    public function zoneIntakeStore(Request $request, TrainingSession $trainingSession, $zone_id)
    {
        ZoneIntake::create(['training_session_id' => $trainingSession->id, 'zone_id' => $zone_id, 'intake' => $request->get('capacity')]);
        return redirect()->route('session.zone.intake', ['training_session' => $trainingSession->id, 'zone_id' => $zone_id])->with('message', 'Zone Intake created successfully');
    }

    public function import()
    {
        $binZones = [
            [
                "አማራ ክልል",
                " ምስራቅ ጎጃም ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ምዕራብ ጎጃም ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ሰሜን ሸዋ ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ደቡብ ወሎ ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ሰሜን ወሎ",
                null,
                null,
                ""
            ],
            [
                "",
                "ደቡብ ጎንደር ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ማዕከላዊ  ጎንደር ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ሰሜን ጎንደር ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ምዕራብ ጎንደር ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ወልቃይት ጠገዴ ሰቲት ሁመራ ዞን",
                null,
                null,
                ""
            ],
            [
                "",
                "ኦሮሞ ብሄረሰብ ዞን አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "አዊ  ብሔረሰብ ዞን አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "ዋግሁምራ  ብሔረሰብ ዞን አስተዳደር ",
                null,
                null,
                ""
            ],
            [
                "",
                "ባህርዳር ከተማ አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "ጎንደር ከተማ አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "ደሴ ከተማ አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "ደብረማርቆስ ከተማ አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "ደብረብርሃን ከተማ አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "",
                "ኮምቦልቻ ከተማ አስተዳደር",
                null,
                null,
                ""
            ],
            [
                "Oromia kelele",
                "Arsi",
                null,
                null,
                ""
            ],
            [
                "",
                "West Arsi",
                null,
                null,
                ""
            ],
            [
                "",
                "Bale ",
                null,
                null,
                ""
            ],
            [
                "",
                "East Bale",
                null,
                null,
                ""
            ],
            [
                "",
                "East Guji",
                null,
                null,
                ""
            ],
            [
                "",
                "West Guji",
                null,
                null,
                ""
            ],
            [
                "",
                "East Hararghe",
                null,
                null,
                ""
            ],
            [
                "",
                "West Hararghe",
                null,
                null,
                ""
            ],
            [
                "",
                "Illu Aba Bora",
                null,
                null,
                ""
            ],
            [
                "",
                "Buno Bedele ",
                null,
                null,
                ""
            ],
            [
                "",
                "Jimma",
                null,
                null,
                ""
            ],
            [
                "",
                "Borena",
                null,
                null,
                ""
            ],
            [
                "",
                "East Wollega",
                null,
                null,
                ""
            ],
            [
                "",
                "West Wollega",
                null,
                null,
                ""
            ],
            [
                "",
                "Qelem Wollega",
                null,
                null,
                ""
            ],
            [
                "",
                "Horo Guduru Wollega",
                null,
                null,
                ""
            ],
            [
                "",
                "East Shewa",
                null,
                null,
                ""
            ],
            [
                "",
                "West Shewa",
                null,
                null,
                ""
            ],
            [
                "",
                "South West Shewa",
                null,
                null,
                ""
            ],
            [
                "",
                "North shewa",
                null,
                null,
                ""
            ],
            [
                "",
                "Finfine Zuria Special",
                null,
                null,
                ""
            ],
            [
                "Somalie kelele",
                "Fafen",
                null,
                null,
                ""
            ],
            [
                "",
                "Jerer",
                null,
                null,
                ""
            ],
            [
                "",
                "Erer",
                null,
                null,
                ""
            ],
            [
                "",
                "Nogob",
                null,
                null,
                ""
            ],
            [
                "",
                "Dawa",
                null,
                null,
                ""
            ],
            [
                "",
                "Korahey",
                null,
                null,
                ""
            ],
            [
                "",
                "Siti",
                null,
                null,
                ""
            ],
            [
                "",
                "Afder",
                null,
                null,
                ""
            ],
            [
                "",
                "Dollo",
                null,
                null,
                ""
            ],
            [
                "",
                "Shebelle",
                null,
                null,
                ""
            ],
            [
                "",
                "Liben",
                null,
                null,
                ""
            ],
            [
                "Sidama kelele",
                "Bansa Clster",
                null,
                null,
                ""
            ],
            [
                "",
                "Hula claster",
                null,
                null,
                ""
            ],
            [
                "",
                "Alta Claster",
                null,
                null,
                ""
            ],
            [
                "",
                "Dale Shabadeno ",
                null,
                null,
                ""
            ],
            [
                "",
                "claster",
                null,
                null,
                ""
            ],
            [
                "",
                "Hawasa zuria ",
                null,
                null,
                ""
            ],
            [
                "Benishangul Gumuz kelele",
                "Assosa",
                null,
                null,
                ""
            ],
            [
                "",
                "Kamash",
                null,
                null,
                ""
            ],
            [
                "",
                "Metekel",
                null,
                null,
                ""
            ],
            [
                "",
                "Ma'o Komo Spe. Woreda",
                null,
                null,
                ""
            ],
            [
                "Gambella kelele",
                "Nuer Bihereseb",
                null,
                null,
                ""
            ],
            [
                "",
                "Agnuak Bihereseb",
                null,
                null,
                ""
            ],
            [
                "",
                "Majang Bihereseb",
                null,
                null,
                ""
            ],
            [
                "",
                "Itang special Woreda",
                null,
                null,
                ""
            ],
            [
                "Harari kelel",
                "Harari",
                null,
                null,
                ""
            ],
            [
                "South West Ethiopian Peoples'",
                "Dawro",
                null,
                null,
                ""
            ],
            [
                "",
                "Kafa",
                null,
                null,
                ""
            ],
            [
                "",
                "Bench Sheko",
                null,
                null,
                ""
            ],
            [
                "",
                "Mi'rab Omo",
                null,
                null,
                ""
            ],
            [
                "",
                "Shaka",
                null,
                null,
                ""
            ],
            [
                "Southern N/,N/ and Peoples'",
                "Siltie",
                null,
                null,
                ""
            ],
            [
                "",
                "Goffa",
                null,
                null,
                ""
            ],
            [
                "",
                "Hadiya",
                null,
                null,
                ""
            ],
            [
                "",
                "Gede'o",
                null,
                null,
                ""
            ],
            [
                "",
                "Halaba",
                null,
                null,
                ""
            ],
            [
                "",
                "Wolaita",
                null,
                null,
                ""
            ],
            [
                "",
                "Kembata Tambaro",
                null,
                null,
                ""
            ],
            [
                "",
                "South Omo",
                null,
                null,
                ""
            ],
            [
                "",
                "Guraghe",
                null,
                null,
                ""
            ],
            [
                "",
                "Konso",
                null,
                null,
                ""
            ],
            [
                "",
                "Gamo",
                null,
                null,
                ""
            ],
            [
                "",
                "Konta Special woreda",
                null,
                null,
                ""
            ],
            [
                "",
                "Burji Special woreda",
                null,
                null,
                ""
            ],
            [
                "",
                "Basketo Special Woreda",
                null,
                null,
                ""
            ],
            [
                "",
                "Derashe special Woreda",
                null,
                null,
                ""
            ],
            [
                "",
                "Yem Special Woreda",
                null,
                null,
                ""
            ],
            [
                "",
                "Amaro ",
                null,
                null,
                ""
            ],
            [
                "Dire Dawa kelel",
                "Ketema Cluster",
                null,
                null,
                ""
            ],
            [
                "",
                "Geter Cluster",
                null,
                null,
                ""
            ],
            [
                "Afar kelel",
                "Zone 1",
                null,
                null,
                ""
            ],
            [
                "",
                "Zone 2",
                null,
                null,
                ""
            ],
            [
                "",
                "Zone 3",
                null,
                null,
                ""
            ],
            [
                "",
                "Zone 4",
                null,
                null,
                ""
            ],
            [
                "",
                "zone 5",
                null,
                null,
                ""
            ]
        ];
        $zones = [];
        $region = null;
        foreach ($binZones as $bin) {
            if($bin[0] != null){
                $region = $bin[0];
            }
            $zoneName = $bin[1];
            $re = Region::where('name',$region)->first();
            Zone::where('name', $zoneName)->firstOr(function () use ($zoneName,$re) {
                Zone::create(['name' => $zoneName, 'status' => 1,'region_id'=>$re->id]);
            });
        }
        dd('Zone imported successfully');
    }
}
