<?php

namespace App\Http\Controllers;

use App\Models\Woreda;
use App\Http\Requests\StoreWoredaRequest;
use App\Http\Requests\UpdateWoredaRequest;
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
        $binWoredas = [
            [
                " ምስራቅ ጎጃም ዞን",
                "እነማይ ወረዳ",
                null
            ],
            [
                null,
                "እናርጅ ዕናውጋ ",
                null
            ],
            [
                null,
                "እነብሴ ",
                null
            ],
            [
                null,
                "ቢቡኝ ",
                null
            ],
            [
                null,
                "ማቻካል ",
                null
            ],
            [
                null,
                "ደጀን ዙሪያ ",
                null
            ],
            [
                null,
                "ደብረ ኤልያስ",
                null
            ],
            [
                null,
                "ጎዛመን ",
                null
            ],
            [
                null,
                "ደባይ ጥላ ግምጃ",
                null
            ],
            [
                null,
                "ሰናን ",
                null
            ],
            [
                null,
                "ሁለቱ እጁ ነብሴ",
                null
            ],
            [
                null,
                "ሞጣ ከተማ",
                null
            ],
            [
                null,
                "ሰዴ  ወረዳ",
                null
            ],
            [
                null,
                "አነደድ ",
                null
            ],
            [
                null,
                "ሸበል በረንታ ",
                null
            ],
            [
                null,
                "ጎንቻ ወረዳ",
                null
            ],
            [
                null,
                "ባሶን ሊበን ",
                null
            ],
            [
                null,
                "አዋበል",
                null
            ],
            [
                "ምዕራብ ጎጃም ዞን",
                "ስሜን ሜጫ ",
                null
            ],
            [
                null,
                "ይልማና ዲንሳ",
                null
            ],
            [
                null,
                "ስሜን አቸፈር",
                null
            ],
            [
                null,
                "ደቡብ አቸፈር ",
                null
            ],
            [
                null,
                "ደንበጫ ",
                null
            ],
            [
                null,
                "ጃቢ ጠህና",
                null
            ],
            [
                null,
                "ሰከላ",
                null
            ],
            [
                null,
                "ወንበርማ",
                null
            ],
            [
                null,
                "ባህርዳር  ዙሪያ",
                null
            ],
            [
                null,
                "ጎንጂ ኦለላ",
                null
            ],
            [
                null,
                "ደቡብ ሜጫ",
                null
            ],
            [
                null,
                "ቡሬ ዙሪያ ",
                null
            ],
            [
                null,
                "ቆሪት",
                null
            ],
            [
                null,
                "ደጋዳሞት",
                null
            ],
            [
                "ሰሜን ሸዋ ዞን",
                "ሞረትና ጅሩ ",
                null
            ],
            [
                null,
                "ሸዋሮቢት",
                null
            ],
            [
                null,
                "ምንጃር ሸንኮራ",
                null
            ],
            [
                null,
                "አለም ከተማ",
                null
            ],
            [
                null,
                "መርሀቤቴ",
                null
            ],
            [
                null,
                "ሞጃና ወደራ ወረዳ",
                null
            ],
            [
                null,
                "አንኮበር",
                null
            ],
            [
                null,
                "በረከት",
                null
            ],
            [
                null,
                "ሀገረማርያም",
                null
            ],
            [
                null,
                "ቀወት",
                null
            ],
            [
                null,
                "ሚዳወረሞ",
                null
            ],
            [
                null,
                "ባሶና ወረና ",
                null
            ],
            [
                null,
                "አንጎለላ ጠራ",
                null
            ],
            [
                null,
                "አንሳሮ",
                null
            ],
            [
                null,
                "አሳግርት",
                null
            ],
            [
                null,
                "ሲያደብርና ዋዮ",
                null
            ],
            [
                null,
                "መንዝ ቀያ",
                null
            ],
            [
                null,
                "መንዝ ላሎ",
                null
            ],
            [
                null,
                "መንዝ ማማ",
                null
            ],
            [
                null,
                "መንዝ ጌራ",
                null
            ],
            [
                null,
                "ግሸር ራቤ ",
                null
            ],
            [
                null,
                "ኤፍራታ ግድም",
                null
            ],
            [
                null,
                "አንፆኪያ ገምዛ",
                null
            ],
            [
                null,
                "ጣርማ በር",
                null
            ],
            [
                null,
                "አነንኮበር",
                null
            ],
            [
                null,
                "ባሶን ሊበን ",
                null
            ],
            [
                "ደቡብ ወሎ ዞን",
                "አምባሰል",
                null
            ],
            [
                null,
                "ኩታበር",
                null
            ],
            [
                null,
                "ወግዲ",
                null
            ],
            [
                null,
                "መቅደላ",
                null
            ],
            [
                null,
                "ቃሉ",
                null
            ],
            [
                null,
                "አልብኮ",
                null
            ],
            [
                null,
                "ወረኢሉ",
                null
            ],
            [
                null,
                "ተውለደሬ",
                null
            ],
            [
                null,
                "ደላንታ",
                null
            ],
            [
                null,
                "ወረባቡ",
                null
            ],
            [
                null,
                "ለገሂዳ",
                null
            ],
            [
                null,
                "ከለላ",
                null
            ],
            [
                null,
                "ጃማ",
                null
            ],
            [
                null,
                "ለጋምቦ",
                null
            ],
            [
                null,
                "አማራ ሳይንት",
                null
            ],
            [
                null,
                "ቦረና",
                null
            ],
            [
                null,
                "መሀል ሳንቲ",
                null
            ],
            [
                null,
                "ደሴ ዙሪያ ",
                null
            ],
            [
                null,
                "አርጎባ",
                null
            ],
            [
                "ሰሜን ወሎ",
                null,
                null
            ],
            [
                null,
                "ወልድያ ",
                null
            ],
            [
                null,
                "ጉባ ላፍቶ",
                null
            ],
            [
                null,
                "መቄት",
                null
            ],
            [
                null,
                "ራያ ቆቦ",
                null
            ],
            [
                null,
                "ቖቦ ከተማ",
                null
            ],
            [
                null,
                "ሀብሩ ወረዳ",
                null
            ],
            [
                null,
                "ግዳን ወረዳ ",
                null
            ],
            [
                null,
                "ጎግና ወረዳ",
                null
            ],
            [
                null,
                "ላስታ",
                null
            ],
            [
                null,
                "አንጎቴ",
                null
            ],
            [
                null,
                "ላሊበላ",
                null
            ],
            [
                null,
                "ጋዞ",
                null
            ],
            [
                null,
                "ዋድላ",
                null
            ],
            [
                null,
                "ዳውንት",
                null
            ],
            [
                null,
                "ሀራ",
                null
            ],
            [
                null,
                "መርሳ",
                null
            ],
            [
                null,
                "ፍላቂት",
                null
            ],
            [
                null,
                "ጋሸና",
                null
            ],
            [
                null,
                "ራያ ባላ",
                null
            ],
            [
                null,
                "አላማጣ ዙሪያ",
                null
            ],
            [
                "ደቡብ ጎንደር ዞን",
                "ደብረታቦት ከተማ",
                null
            ],
            [
                null,
                "እስቴ",
                null
            ],
            [
                null,
                "ሊቦ ከምከም",
                null
            ],
            [
                null,
                "ታችጋይንት ",
                null
            ],
            [
                null,
                "ላይ ጋይንት",
                null
            ],
            [
                null,
                "ፋርጣ",
                null
            ],
            [
                null,
                "ስማዳ",
                null
            ],
            [
                null,
                "ጉና በየምድር",
                null
            ],
            [
                null,
                "አንዳቤት",
                null
            ],
            [
                null,
                "ሰዴ ሙጫ",
                null
            ],
            [
                null,
                "እብናት",
                null
            ],
            [
                null,
                "ፎገራ",
                null
            ],
            [
                null,
                "አዲስ ዘመን",
                null
            ],
            [
                null,
                "ደራ",
                null
            ],
            [
                "ማዕከላዊ  ጎንደር ዞን",
                "ጎንደር ዙሪያ",
                null
            ],
            [
                null,
                "ምስራቅ ደንቢያ",
                null
            ],
            [
                null,
                "ምጎራብ በለሳ",
                null
            ],
            [
                null,
                "አለፋ",
                null
            ],
            [
                null,
                "ላይአርማጭሆ",
                null
            ],
            [
                null,
                "ጣቁሳ",
                null
            ],
            [
                null,
                "ምዕራብ ደንቢያ",
                null
            ],
            [
                null,
                "ምስራቅ በለሳ",
                null
            ],
            [
                null,
                "ወገራ",
                null
            ],
            [
                null,
                "ታች አርማጭሆ",
                null
            ],
            [
                null,
                "ኪንፋዝ",
                null
            ],
            [
                null,
                "መሀል አርማጭሆ",
                null
            ],
            [
                null,
                "ጠገዴ",
                null
            ],
            [
                null,
                "ጭልጋ ቁጥር 1",
                null
            ],
            [
                null,
                "ጭልጋ ቁጥር 2",
                null
            ],
            [
                null,
                "አምባ ጊዮርጊስ",
                null
            ],
            [
                "ሰሜን ጎንደር ዞን",
                "ደባርቅ ዙሪያ",
                null
            ],
            [
                null,
                "ጸለምት",
                null
            ],
            [
                null,
                "በየደ",
                null
            ],
            [
                null,
                "ጃንአሞራ",
                null
            ],
            [
                null,
                "አደርቃይ",
                null
            ],
            [
                null,
                "ዳቫት ዙሪያ",
                null
            ],
            [
                null,
                "ዲማ ምስራቅ ጸለምት",
                null
            ],
            [
                null,
                "ማይጸብሬ ዙሪያ ምዕራብ ጠለምት",
                null
            ],
            [
                "ምዕራብ ጎንደር ዞን",
                "ምዕራብ አርማጭዎ ",
                null
            ],
            [
                null,
                "ምድረ-ገነት",
                null
            ],
            [
                null,
                "ቋራ",
                null
            ],
            [
                null,
                "አዳኝአገር ጫቆ",
                null
            ],
            [
                null,
                "መተማ",
                null
            ],
            [
                "ወልቃይት ጠገዴ ሰቲት ሁመራ ዞን",
                "ወልቃይት ወረዳ",
                null
            ],
            [
                null,
                "አውራ",
                null
            ],
            [
                null,
                "ቆራሪት",
                null
            ],
            [
                null,
                "ቃፍታ ሁመራ",
                null
            ],
            [
                null,
                "ማክሰኞ ገበያ",
                null
            ],
            [
                "ኦሮሞ ብሄረሰብ ዞን አስተዳደር",
                "ጅሌ ጥሙጋ",
                null
            ],
            [
                null,
                "አርጡማ ፋርሲ",
                null
            ],
            [
                null,
                "ደዌ ሀረዋ",
                null
            ],
            [
                null,
                "ባቲ ዙሪያ",
                null
            ],
            [
                null,
                "ዳዋ ጨፋ",
                null
            ],
            [
                "አዊ  ብሔረሰብ ዞን አስተዳደር",
                "ባንጃ ወረዳ",
                null
            ],
            [
                null,
                "እየውንጐንሳ",
                null
            ],
            [
                null,
                "አንከሻ",
                null
            ],
            [
                null,
                "ጓንጓ",
                null
            ],
            [
                null,
                "ጃዊ",
                null
            ],
            [
                null,
                "ፋግታ",
                null
            ],
            [
                null,
                "ዳንግላ",
                null
            ],
            [
                null,
                "ጓጉሳ ",
                null
            ],
            [
                "ዋግሁምራ  ብሔረሰብ ዞን አስተዳደር ",
                "አበርገሌ ወረዳ",
                null
            ],
            [
                null,
                "ዳህና ወረዳ",
                null
            ],
            [
                null,
                "ሰቆጣ ዙሪያ",
                null
            ],
            [
                null,
                "ዋግብጂ ",
                null
            ],
            [
                null,
                "ጋዝጊብላ",
                null
            ],
            [
                null,
                "ዝቋላ",
                null
            ],
            [
                null,
                "ጎሀላ",
                null
            ],
            [
                null,
                "ዛታ",
                null
            ],
            [
                null,
                "ኦፍላ",
                null
            ],
            [
                "ባህርዳር ከተማ አስተዳደር",
                null,
                null
            ],
            [
                "ጎንደር ከተማ አስተዳደር",
                null,
                null
            ],
            [
                "ደሴ ከተማ አስተዳደር",
                null,
                null
            ],
            [
                "ደብረማርቆስ ከተማ አስተዳደር",
                null,
                null
            ],
            [
                "ደብረብርሃን ከተማ አስተዳደር",
                null,
                null
            ],
            [
                "ኮምቦልቻ ከተማ አስተዳደር",
                null,
                null
            ],
            [
                "Arsi",
                "Lemu Fi Bilbilo",
                null
            ],
            [
                null,
                "Munesa",
                null
            ],
            [
                null,
                "Tiyo",
                null
            ],
            [
                null,
                "Digelu Fi Tijo",
                null
            ],
            [
                null,
                "Robie",
                null
            ],
            [
                null,
                "Tana",
                null
            ],
            [
                null,
                "Sude",
                null
            ],
            [
                null,
                "Hetosa",
                null
            ],
            [
                null,
                "Gololcha",
                null
            ],
            [
                null,
                "Jaju",
                null
            ],
            [
                null,
                "Zuway-Dugda",
                null
            ],
            [
                null,
                "Merti",
                null
            ],
            [
                null,
                "Seru",
                null
            ],
            [
                null,
                "Amigna",
                null
            ],
            [
                null,
                "Shirka",
                null
            ],
            [
                null,
                "Dodota",
                null
            ],
            [
                null,
                "Asako",
                null
            ],
            [
                null,
                "Chole",
                null
            ],
            [
                null,
                "Diksis",
                null
            ],
            [
                null,
                "Lode Hetosa",
                null
            ],
            [
                null,
                "Bale Gesgar",
                null
            ],
            [
                null,
                "Guna",
                null
            ],
            [
                null,
                "Sire",
                null
            ],
            [
                null,
                "Inkolo Wabe",
                null
            ],
            [
                null,
                "Shenan Kolu",
                null
            ],
            [
                "West Arsi",
                null,
                null
            ],
            [
                null,
                "Arsi Negele",
                null
            ],
            [
                null,
                "Siraro",
                null
            ],
            [
                null,
                "Shala",
                null
            ],
            [
                null,
                "Gedeb",
                null
            ],
            [
                null,
                "Kofele",
                null
            ],
            [
                null,
                "Kore",
                null
            ],
            [
                null,
                "Dodola",
                null
            ],
            [
                null,
                "Kokoksa",
                null
            ],
            [
                null,
                "Addaba",
                null
            ],
            [
                null,
                "Nanseb",
                null
            ],
            [
                null,
                "Wendo",
                null
            ],
            [
                null,
                "Heban Arsi",
                null
            ],
            [
                null,
                "ነነዋ ሻሻ",
                null
            ],
            [
                "Bale ",
                "Sinana",
                null
            ],
            [
                null,
                "Gindhir",
                null
            ],
            [
                null,
                "Goba",
                null
            ],
            [
                null,
                "Berbere",
                null
            ],
            [
                null,
                "Agarfa",
                null
            ],
            [
                null,
                "Guradamole",
                null
            ],
            [
                null,
                "Goro",
                null
            ],
            [
                null,
                "Meda Welabu",
                null
            ],
            [
                null,
                "Dollo Mena",
                null
            ],
            [
                null,
                "Gasera",
                null
            ],
            [
                null,
                "Herana Buluq",
                null
            ],
            [
                null,
                "Dinsho",
                null
            ],
            [
                "East Bale",
                "Gololcha",
                null
            ],
            [
                null,
                "Lege-Hida",
                null
            ],
            [
                null,
                "Rayitu",
                null
            ],
            [
                null,
                "Sawena",
                null
            ],
            [
                null,
                "Dawe Qechan",
                null
            ],
            [
                null,
                "Dawe Serer",
                null
            ],
            [
                null,
                "ጊኒር",
                null
            ],
            [
                null,
                "ጋሰራ",
                null
            ],
            [
                "East Guji",
                "Uraga",
                null
            ],
            [
                null,
                "Borena",
                null
            ],
            [
                null,
                "Adola",
                null
            ],
            [
                null,
                "Odo Shakiso",
                null
            ],
            [
                null,
                "Liben",
                null
            ],
            [
                null,
                "Wadera",
                null
            ],
            [
                null,
                "Girja",
                null
            ],
            [
                null,
                "Afale Kola (Dama)",
                null
            ],
            [
                null,
                "Ana Sora",
                null
            ],
            [
                null,
                "Gora Dola",
                null
            ],
            [
                null,
                "Saba Boru",
                null
            ],
            [
                null,
                "Haro Welabu",
                null
            ],
            [
                null,
                "Aga Wayyu",
                null
            ],
            [
                null,
                "Gumi Eldello",
                null
            ],
            [
                null,
                "Arda Jila",
                null
            ],
            [
                "West Guji",
                "Gelana",
                null
            ],
            [
                null,
                "Abaya",
                null
            ],
            [
                null,
                "Bule Hora",
                null
            ],
            [
                null,
                "Melka Sodda",
                null
            ],
            [
                null,
                "Dugda Dawa",
                null
            ],
            [
                null,
                "Hambala Wamana",
                null
            ],
            [
                null,
                "Kercha",
                null
            ],
            [
                null,
                "Soru Burguda",
                null
            ],
            [
                null,
                "Birbirsa Kojowa",
                null
            ],
            [
                "East Hararghe",
                "Goro Gutu",
                null
            ],
            [
                null,
                "Marka Bal'O",
                null
            ],
            [
                null,
                "Bedeno",
                null
            ],
            [
                null,
                "Kombolcha",
                null
            ],
            [
                null,
                "Fedis",
                null
            ],
            [
                null,
                "Deder",
                null
            ],
            [
                null,
                "Kersa",
                null
            ],
            [
                null,
                "Haro Maya",
                null
            ],
            [
                null,
                "Metta",
                null
            ],
            [
                null,
                "Kurfa Chale",
                null
            ],
            [
                null,
                "Girawa",
                null
            ],
            [
                null,
                "Gola Odda",
                null
            ],
            [
                null,
                "Jarso",
                null
            ],
            [
                null,
                "Gursum",
                null
            ],
            [
                null,
                "Babile",
                null
            ],
            [
                null,
                "Mayu Muluqe",
                null
            ],
            [
                null,
                "Chinaksen",
                null
            ],
            [
                null,
                "Midaga Tola",
                null
            ],
            [
                null,
                "Qumbi",
                null
            ],
            [
                null,
                "Goro Muxi",
                null
            ],
            [
                "West Hararghe",
                "አንቻር",
                null
            ],
            [
                null,
                "በዴሳ",
                null
            ],
            [
                null,
                "ቦኬ",
                null
            ],
            [
                null,
                "ጭሮ",
                null
            ],
            [
                null,
                "ናናዋ ጭሮ",
                null
            ],
            [
                null,
                "ገመችስ",
                null
            ],
            [
                null,
                "ገለምሶ",
                null
            ],
            [
                null,
                "ዳሮ ለቡ",
                null
            ],
            [
                null,
                "ዶባ",
                null
            ],
            [
                null,
                "ጉባ ቆርቻ",
                null
            ],
            [
                null,
                "ሀቢሮ",
                null
            ],
            [
                null,
                "ጎዳ ውልቶ",
                null
            ],
            [
                null,
                "ሸነን ዱጎ",
                null
            ],
            [
                null,
                "ሚኢሶ",
                null
            ],
            [
                null,
                "ቱሎ",
                null
            ],
            [
                null,
                "ሀዊ ጉድና",
                null
            ],
            [
                null,
                "ቡርቃ ዲምቱ",
                null
            ],
            [
                null,
                "ጉምቢ ቦርዴዴ",
                null
            ],
            [
                null,
                "አደኣ በርጋ",
                null
            ],
            [
                "Illu Aba Bora",
                "Darimu",
                null
            ],
            [
                null,
                "Mettu",
                null
            ],
            [
                null,
                "Yayo",
                null
            ],
            [
                null,
                "Alle",
                null
            ],
            [
                null,
                "Suphe,Soddo Fi Sech",
                null
            ],
            [
                null,
                "Bure",
                null
            ],
            [
                null,
                "Nono Fi Sale",
                null
            ],
            [
                null,
                "Becho",
                null
            ],
            [
                null,
                "Hurumu",
                null
            ],
            [
                null,
                "Didu",
                null
            ],
            [
                null,
                "Halu",
                null
            ],
            [
                null,
                "Bilo Fi Nopha",
                null
            ],
            [
                null,
                "Dorani",
                null
            ],
            [
                null,
                "አልጌሰቺ",
                null
            ],
            [
                "Buno Bedele ",
                "Bedele",
                null
            ],
            [
                null,
                "Borecha",
                null
            ],
            [
                null,
                "Dega Damot",
                null
            ],
            [
                null,
                "Chora",
                null
            ],
            [
                null,
                "Gechi",
                null
            ],
            [
                null,
                "Didesa",
                null
            ],
            [
                null,
                "Meko",
                null
            ],
            [
                null,
                "Dabo Hanna",
                null
            ],
            [
                null,
                "Chawaqa",
                null
            ],
            [
                "Jimma",
                "Limmu Seqa",
                null
            ],
            [
                null,
                "Sokoru",
                null
            ],
            [
                null,
                "Kersa",
                null
            ],
            [
                null,
                "Mana",
                null
            ],
            [
                null,
                "Limmu Kosa",
                null
            ],
            [
                null,
                "Gomma",
                null
            ],
            [
                null,
                "Seqa Choqorsa",
                null
            ],
            [
                null,
                "Dedo",
                null
            ],
            [
                null,
                "Omo Nada",
                null
            ],
            [
                null,
                "Chiro Afata",
                null
            ],
            [
                null,
                "Gera",
                null
            ],
            [
                null,
                "Sigmo",
                null
            ],
            [
                null,
                "Setama",
                null
            ],
            [
                null,
                "Gumayi",
                null
            ],
            [
                null,
                "Chora Botor",
                null
            ],
            [
                null,
                "Shabe Sombo",
                null
            ],
            [
                null,
                "Nono Benja",
                null
            ],
            [
                null,
                "Mancho",
                null
            ],
            [
                null,
                "Omo Beyan",
                null
            ],
            [
                null,
                "Botor Tolay",
                null
            ],
            [
                "Borena",
                "Yabello",
                null
            ],
            [
                null,
                "Arero",
                null
            ],
            [
                null,
                "Teltele",
                null
            ],
            [
                null,
                "Moyalle",
                null
            ],
            [
                null,
                "Dire",
                null
            ],
            [
                null,
                "Mi'O",
                null
            ],
            [
                null,
                "Dilo",
                null
            ],
            [
                null,
                "Das",
                null
            ],
            [
                null,
                "Wachile",
                null
            ],
            [
                null,
                "Elawaya",
                null
            ],
            [
                null,
                "Guchi",
                null
            ],
            [
                null,
                "Dubluq",
                null
            ],
            [
                "East Wollega",
                "Guto Gida",
                null
            ],
            [
                null,
                "Gida Ayana",
                null
            ],
            [
                null,
                "Sasiga",
                null
            ],
            [
                null,
                "Jimma Arjo",
                null
            ],
            [
                null,
                "Sibu Sire",
                null
            ],
            [
                null,
                "Limmu",
                null
            ],
            [
                null,
                "Ibantu",
                null
            ],
            [
                null,
                "Leqa Dulacha",
                null
            ],
            [
                null,
                "Wama Agalo",
                null
            ],
            [
                null,
                "Gudaya Bila",
                null
            ],
            [
                null,
                "Nunu Qumba",
                null
            ],
            [
                null,
                "Diga Leqa",
                null
            ],
            [
                null,
                "Gubu Sayo",
                null
            ],
            [
                null,
                "Wayu Tuqa",
                null
            ],
            [
                null,
                "Bonaya Boshe",
                null
            ],
            [
                null,
                "Haro",
                null
            ],
            [
                null,
                "Kiramu",
                null
            ],
            [
                "West Wollega",
                "Nedjo",
                null
            ],
            [
                null,
                "Gimbi",
                null
            ],
            [
                null,
                "Nole Kaba",
                null
            ],
            [
                null,
                "Yubdo",
                null
            ],
            [
                null,
                "Jarso",
                null
            ],
            [
                null,
                "Haru",
                null
            ],
            [
                null,
                "Begi",
                null
            ],
            [
                null,
                "Guliso",
                null
            ],
            [
                null,
                "Boji Dirmaji",
                null
            ],
            [
                null,
                "Mana Sibu",
                null
            ],
            [
                null,
                "Laalo Asabi",
                null
            ],
            [
                null,
                "Genji",
                null
            ],
            [
                null,
                "Boji Choqorsa",
                null
            ],
            [
                null,
                "Sayo Nole",
                null
            ],
            [
                null,
                "Kondala",
                null
            ],
            [
                null,
                "Kiltu Kara",
                null
            ],
            [
                null,
                "Babo Gambel",
                null
            ],
            [
                null,
                "Homa",
                null
            ],
            [
                null,
                "Ayira",
                null
            ],
            [
                null,
                "Letu Sibu",
                null
            ],
            [
                "Qelem Wollega",
                "Sayo  ",
                null
            ],
            [
                null,
                "Dale Wabera",
                null
            ],
            [
                null,
                "Anfilo",
                null
            ],
            [
                null,
                "Gidami",
                null
            ],
            [
                null,
                "Hawa Welel",
                null
            ],
            [
                null,
                "Dale Sadi",
                null
            ],
            [
                null,
                "Lalo Qile",
                null
            ],
            [
                null,
                "Jimma Horo",
                null
            ],
            [
                null,
                "Gawo Qebe",
                null
            ],
            [
                null,
                "Yemalogi Welel",
                null
            ],
            [
                null,
                "Chanka Sedi",
                null
            ],
            [
                "Horo Guduru Wollega",
                "Guduru",
                null
            ],
            [
                null,
                "Abay Choman",
                null
            ],
            [
                null,
                "Horo",
                null
            ],
            [
                null,
                "Abe Dongoro",
                null
            ],
            [
                null,
                "Jardaga Jarte",
                null
            ],
            [
                null,
                "Jimma Rare",
                null
            ],
            [
                null,
                "Amuru",
                null
            ],
            [
                null,
                "Jimma Geneti",
                null
            ],
            [
                null,
                "Hababo Guduru",
                null
            ],
            [
                null,
                "Choman Guduru",
                null
            ],
            [
                "East Shewa",
                "Ada'A",
                null
            ],
            [
                null,
                "Adama",
                null
            ],
            [
                null,
                "Adami Tulu Fi Jido Kombolcha",
                null
            ],
            [
                null,
                "Lume",
                null
            ],
            [
                null,
                "Dugda Dawa",
                null
            ],
            [
                null,
                "Boset",
                null
            ],
            [
                null,
                "Fentale",
                null
            ],
            [
                null,
                "Gimbichu",
                null
            ],
            [
                null,
                "Liben Chuqala",
                null
            ],
            [
                null,
                "Bora",
                null
            ],
            [
                "West Shewa",
                "Gendeberet",
                null
            ],
            [
                null,
                "Jeldu",
                null
            ],
            [
                null,
                "Bako Tibe",
                null
            ],
            [
                null,
                "Chaliya",
                null
            ],
            [
                null,
                "Ambo",
                null
            ],
            [
                null,
                "Dendi",
                null
            ],
            [
                null,
                "Dano",
                null
            ],
            [
                null,
                "Nono",
                null
            ],
            [
                null,
                "Ejere",
                null
            ],
            [
                null,
                "Metta Robi",
                null
            ],
            [
                null,
                "Ada'A Berga",
                null
            ],
            [
                null,
                "Dire Inchini (Tuqur)",
                null
            ],
            [
                null,
                "Midakigni",
                null
            ],
            [
                null,
                "Toke Kutaye",
                null
            ],
            [
                null,
                "Abune Gindeberet",
                null
            ],
            [
                null,
                "Jibet",
                null
            ],
            [
                null,
                "Ilu Gelan",
                null
            ],
            [
                null,
                "Ejersa Lefo",
                null
            ],
            [
                null,
                "Metta Welkite",
                null
            ],
            [
                null,
                "Chobi",
                null
            ],
            [
                null,
                "Liben Jawi",
                null
            ],
            [
                "South West Shewa",
                "Weliso",
                null
            ],
            [
                null,
                "Wenchi",
                null
            ],
            [
                null,
                "Amaya",
                null
            ],
            [
                null,
                "Dawo",
                null
            ],
            [
                null,
                "Ilu",
                null
            ],
            [
                null,
                "Becho",
                null
            ],
            [
                null,
                "Tole",
                null
            ],
            [
                null,
                "Qersa Fi Malima",
                null
            ],
            [
                null,
                "Seden Soddo",
                null
            ],
            [
                null,
                "Soddo Dachi",
                null
            ],
            [
                "North Shewa",
                "Wera Jarso",
                null
            ],
            [
                null,
                "Kuyu",
                null
            ],
            [
                null,
                "Degem",
                null
            ],
            [
                null,
                "Hidabu Abote",
                null
            ],
            [
                null,
                "Girar Jarso",
                null
            ],
            [
                null,
                "Dera",
                null
            ],
            [
                null,
                "Yaya Gulele",
                null
            ],
            [
                null,
                "Wuchale",
                null
            ],
            [
                null,
                "Kinbibit",
                null
            ],
            [
                null,
                "Abichu Fi Gna'A",
                null
            ],
            [
                null,
                "Aleltu",
                null
            ],
            [
                null,
                "Debre Libanos",
                null
            ],
            [
                null,
                "Jida",
                null
            ],
            [
                "Finfine Zuria Special",
                "Akaki",
                null
            ],
            [
                null,
                "Sululta",
                null
            ],
            [
                null,
                "Barak",
                null
            ],
            [
                null,
                "Welmera",
                null
            ],
            [
                null,
                "Sebeta Hawas",
                null
            ],
            [
                null,
                "Mulo",
                null
            ],
            [
                "Fafen",
                "Shebeley",
                null
            ],
            [
                null,
                "Gursum",
                null
            ],
            [
                null,
                "Babile",
                null
            ],
            [
                null,
                "Tuli Guled",
                null
            ],
            [
                null,
                "Harores",
                null
            ],
            [
                null,
                "Awbere",
                null
            ],
            [
                null,
                "Harawo",
                null
            ],
            [
                null,
                "Harshin",
                null
            ],
            [
                null,
                "Kebribeyah",
                null
            ],
            [
                null,
                "Mula",
                null
            ],
            [
                null,
                "Goljano",
                null
            ],
            [
                "Jerer",
                "Degehabur",
                null
            ],
            [
                null,
                "Degeha Madiw",
                null
            ],
            [
                null,
                "Gashamo",
                null
            ],
            [
                null,
                "Gunegado",
                null
            ],
            [
                null,
                "Bililbur",
                null
            ],
            [
                null,
                "Bilkot",
                null
            ],
            [
                null,
                "Dig",
                null
            ],
            [
                null,
                "Daror",
                null
            ],
            [
                null,
                "Aware",
                null
            ],
            [
                null,
                "Yo'Ale",
                null
            ],
            [
                null,
                "Ararso",
                null
            ],
            [
                "Erer",
                "Fik",
                null
            ],
            [
                null,
                "Salahad",
                null
            ],
            [
                null,
                "Maya Muluka",
                null
            ],
            [
                null,
                "Kubi",
                null
            ],
            [
                null,
                "Wangay",
                null
            ],
            [
                null,
                "Ya'Ob",
                null
            ],
            [
                null,
                "Hamaro",
                null
            ],
            [
                "Nogob",
                "Elwayne",
                null
            ],
            [
                null,
                "Ayun",
                null
            ],
            [
                null,
                "Hora Shagah",
                null
            ],
            [
                null,
                "Dayun",
                null
            ],
            [
                null,
                "Sagag",
                null
            ],
            [
                null,
                "Hararay",
                null
            ],
            [
                null,
                "Garbo",
                null
            ],
            [
                "Dawa",
                "Moyalle",
                null
            ],
            [
                null,
                "Mubarek",
                null
            ],
            [
                null,
                "Kededuma",
                null
            ],
            [
                null,
                "Hudet",
                null
            ],
            [
                "Korahey",
                "Kebridehar",
                null
            ],
            [
                null,
                "Doba Wayin",
                null
            ],
            [
                null,
                "Bodaley",
                null
            ],
            [
                null,
                "Shay-Kosh",
                null
            ],
            [
                null,
                "Las Dan Koyr",
                null
            ],
            [
                null,
                "Marsin",
                null
            ],
            [
                null,
                "Kundubur",
                null
            ],
            [
                null,
                "Li-Ogaden",
                null
            ],
            [
                null,
                "Shilabo",
                null
            ],
            [
                null,
                "Hig-Loley",
                null
            ],
            [
                "Siti",
                "Shinley",
                null
            ],
            [
                null,
                "Mi'Eso",
                null
            ],
            [
                null,
                "Erer",
                null
            ],
            [
                null,
                "Aysha'E",
                null
            ],
            [
                null,
                "Denbel",
                null
            ],
            [
                null,
                "Hadigale",
                null
            ],
            [
                null,
                "Geblalu",
                null
            ],
            [
                null,
                "Afdem",
                null
            ],
            [
                null,
                "Kota Biki",
                null
            ],
            [
                "Afder",
                "Hargele",
                null
            ],
            [
                null,
                "Raso",
                null
            ],
            [
                null,
                "Elkere",
                null
            ],
            [
                null,
                "Chereti",
                null
            ],
            [
                null,
                "Mi'Rab Imi",
                null
            ],
            [
                null,
                "Dollo Bay",
                null
            ],
            [
                null,
                "Barey",
                null
            ],
            [
                null,
                "God-God",
                null
            ],
            [
                null,
                "Kohley",
                null
            ],
            [
                "Dollo",
                "Warder",
                null
            ],
            [
                null,
                "Lehel-Yub",
                null
            ],
            [
                null,
                "Danod",
                null
            ],
            [
                null,
                "Galadi",
                null
            ],
            [
                null,
                "Bok",
                null
            ],
            [
                null,
                "Dertole",
                null
            ],
            [
                null,
                "Gal-Hamer",
                null
            ],
            [
                "Shebelle",
                "Godie",
                null
            ],
            [
                null,
                "Adadile",
                null
            ],
            [
                null,
                "Mustahil",
                null
            ],
            [
                null,
                "Denan",
                null
            ],
            [
                null,
                "Elele",
                null
            ],
            [
                null,
                "Ber'Ano",
                null
            ],
            [
                null,
                "Kelafo",
                null
            ],
            [
                null,
                "Abakoro",
                null
            ],
            [
                null,
                "Ferfer",
                null
            ],
            [
                "Liben",
                "Filtu",
                null
            ],
            [
                null,
                "Deka Softu",
                null
            ],
            [
                null,
                "Kersa Dula",
                null
            ],
            [
                null,
                "Guradamole",
                null
            ],
            [
                null,
                "Dollow Ado",
                null
            ],
            [
                null,
                "Goro Bekeksa",
                null
            ],
            [
                null,
                "Bokol Mayu",
                null
            ],
            [
                "Bansa Clster",
                "Bansa",
                null
            ],
            [
                null,
                "Bura",
                null
            ],
            [
                null,
                "Dala",
                null
            ],
            [
                null,
                "Chare",
                null
            ],
            [
                null,
                "Aroresa",
                null
            ],
            [
                null,
                "Hoko",
                null
            ],
            [
                null,
                "Chabe Gambelto",
                null
            ],
            [
                "Hula Claster",
                "Bona Zuria",
                null
            ],
            [
                null,
                "Hula",
                null
            ],
            [
                null,
                "Cherone",
                null
            ],
            [
                null,
                "Tatecha",
                null
            ],
            [
                null,
                "Buresa",
                null
            ],
            [
                null,
                "Shafamo",
                null
            ],
            [
                null,
                "Arebagona",
                null
            ],
            [
                "Alta Claster",
                "Alta Wondo ",
                null
            ],
            [
                null,
                "Alta Wondo Town",
                null
            ],
            [
                null,
                "Alta Chuko ",
                null
            ],
            [
                null,
                "Alta Chuko  Town ",
                null
            ],
            [
                null,
                "Dara ",
                null
            ],
            [
                null,
                "Dara Ontiso",
                null
            ],
            [
                "Dale Shabadeno ",
                "Dale",
                null
            ],
            [
                "Claster",
                "Yergalem",
                null
            ],
            [
                null,
                "Wonesho",
                null
            ],
            [
                null,
                "Laku",
                null
            ],
            [
                null,
                "Gorecha",
                null
            ],
            [
                null,
                "Luka",
                null
            ],
            [
                "Hawasa Zuria ",
                "Hawasa Zuria",
                null
            ],
            [
                null,
                "Malega",
                null
            ],
            [
                null,
                "Hawela",
                null
            ],
            [
                null,
                "Wondo Ganate",
                null
            ],
            [
                null,
                "Belate",
                null
            ],
            [
                null,
                "Darar",
                null
            ],
            [
                null,
                "Borecha",
                null
            ],
            [
                "Assosa",
                "Assosa",
                null
            ],
            [
                null,
                "Komosha",
                null
            ],
            [
                null,
                "Kurmuk",
                null
            ],
            [
                null,
                "Mengie",
                null
            ],
            [
                null,
                "Shergole",
                null
            ],
            [
                null,
                "Bildi -Gilu",
                null
            ],
            [
                null,
                "Bamebasi",
                null
            ],
            [
                "Kamash",
                "Kamash",
                null
            ],
            [
                null,
                "Agalo Mepi",
                null
            ],
            [
                null,
                "Sedan",
                null
            ],
            [
                null,
                "Yaso",
                null
            ],
            [
                null,
                "Mishishiga (Beloji Kampoy)",
                null
            ],
            [
                "Metekel",
                "Guba",
                null
            ],
            [
                null,
                "Dangur",
                null
            ],
            [
                null,
                "Pawi",
                null
            ],
            [
                null,
                "Mandura",
                null
            ],
            [
                null,
                "Dibati",
                null
            ],
            [
                null,
                "Bulen",
                null
            ],
            [
                null,
                "Wonbera",
                null
            ],
            [
                "Ma'O Komo Spe. Woreda",
                "Ma'O Komo",
                null
            ],
            [
                null,
                "Woreda 01and 02",
                null
            ],
            [
                "Nuer Bihereseb",
                "Lare",
                null
            ],
            [
                null,
                "Jikawo",
                null
            ],
            [
                null,
                "Makuwey",
                null
            ],
            [
                null,
                "Wntuwar",
                null
            ],
            [
                null,
                "Akobo",
                null
            ],
            [
                "Agnuak Bihereseb",
                "Gambella",
                null
            ],
            [
                null,
                "Abobo",
                null
            ],
            [
                null,
                "Goge",
                null
            ],
            [
                null,
                "Jore",
                null
            ],
            [
                null,
                "Dimma",
                null
            ],
            [
                "Majang Bihereseb",
                "Godere",
                null
            ],
            [
                null,
                "Mengesh",
                null
            ],
            [
                "Itang Special Woreda",
                "   Itang ",
                null
            ],
            [
                "Harari",
                "Amir Nur",
                null
            ],
            [
                null,
                "Abadir",
                null
            ],
            [
                null,
                "Shenkor",
                null
            ],
            [
                null,
                "Awboker",
                null
            ],
            [
                null,
                "Hakim",
                null
            ],
            [
                null,
                "Sofi",
                null
            ],
            [
                null,
                "Erer",
                null
            ],
            [
                null,
                "Dire Teyara",
                null
            ],
            [
                "Dawro",
                "Maraka",
                null
            ],
            [
                null,
                "Mari Mansa",
                null
            ],
            [
                null,
                "Zaba Gazo",
                null
            ],
            [
                null,
                "Gena",
                null
            ],
            [
                null,
                "Tocha",
                null
            ],
            [
                null,
                "Kechi",
                null
            ],
            [
                null,
                "Loma",
                null
            ],
            [
                null,
                "Disa",
                null
            ],
            [
                null,
                "Isara",
                null
            ],
            [
                null,
                "Tercha Zuria",
                null
            ],
            [
                "Kafa",
                "Bita",
                null
            ],
            [
                null,
                "Chena",
                null
            ],
            [
                null,
                "Saylem",
                null
            ],
            [
                null,
                "Ginbo",
                null
            ],
            [
                null,
                "Decha",
                null
            ],
            [
                null,
                "Telo",
                null
            ],
            [
                null,
                "Decha Town",
                null
            ],
            [
                null,
                "Gesha",
                null
            ],
            [
                null,
                "Gewata",
                null
            ],
            [
                null,
                "Goba",
                null
            ],
            [
                null,
                "Cheta",
                null
            ],
            [
                null,
                "Adiyo",
                null
            ],
            [
                null,
                "Shishonde",
                null
            ],
            [
                "Bench Sheko",
                "Sheh Bench",
                null
            ],
            [
                null,
                "Debub Bench",
                null
            ],
            [
                null,
                "Siemen Bench",
                null
            ],
            [
                null,
                "Gidi Bench",
                null
            ],
            [
                null,
                "Gura Ferda",
                null
            ],
            [
                null,
                "Sheko",
                null
            ],
            [
                "Mi'Rab Omo",
                "Me'Init Shasha",
                null
            ],
            [
                null,
                "Me'Nit Goldiya",
                null
            ],
            [
                null,
                "Surma",
                null
            ],
            [
                null,
                "Bero",
                null
            ],
            [
                null,
                "Gesha",
                null
            ],
            [
                null,
                "Maji",
                null
            ],
            [
                "Shaka",
                "Masha",
                null
            ],
            [
                null,
                "Andracha",
                null
            ],
            [
                null,
                "Yeki",
                null
            ],
            [
                "Siltie",
                "Mito",
                null
            ],
            [
                null,
                "Misrak Silti",
                null
            ],
            [
                null,
                "Lanfaro",
                null
            ],
            [
                null,
                "Halicho Worero",
                null
            ],
            [
                null,
                "Mi'Rab Azernet",
                null
            ],
            [
                null,
                "Misrak Azernet",
                null
            ],
            [
                null,
                "Sankura",
                null
            ],
            [
                null,
                "Wulebareg",
                null
            ],
            [
                null,
                "Dalocha",
                null
            ],
            [
                null,
                "Silti",
                null
            ],
            [
                "Goffa",
                "Zala",
                null
            ],
            [
                null,
                "Melo Koza",
                null
            ],
            [
                null,
                "Malo Koda",
                null
            ],
            [
                null,
                "Uba Debretsehai",
                null
            ],
            [
                null,
                "Demba Goffa",
                null
            ],
            [
                null,
                "Geze Goffa",
                null
            ],
            [
                null,
                "Oyida",
                null
            ],
            [
                "Hadiya",
                "Lemo",
                null
            ],
            [
                null,
                "Anlemo",
                null
            ],
            [
                null,
                "Shashego",
                null
            ],
            [
                null,
                "Mi'Rab Soro",
                null
            ],
            [
                null,
                "Misrak Badewacho",
                null
            ],
            [
                null,
                "Siraro",
                null
            ],
            [
                null,
                "Mi'Rab Badewacho",
                null
            ],
            [
                null,
                "Duna",
                null
            ],
            [
                null,
                "Soro",
                null
            ],
            [
                null,
                "Gibe",
                null
            ],
            [
                null,
                "Gombora",
                null
            ],
            [
                null,
                "Misha",
                null
            ],
            [
                null,
                "Hameka",
                null
            ],
            [
                "Gede'O",
                "Dilla Zuria",
                null
            ],
            [
                null,
                "Wonago",
                null
            ],
            [
                null,
                "Yirgachefie",
                null
            ],
            [
                null,
                "Kochere",
                null
            ],
            [
                null,
                "Gedeb",
                null
            ],
            [
                null,
                "Bulen",
                null
            ],
            [
                null,
                "Rephi",
                null
            ],
            [
                "Halaba",
                "Atote Hulo",
                null
            ],
            [
                null,
                "Woyra",
                null
            ],
            [
                null,
                "Woyra Deja",
                null
            ],
            [
                "Wolaita",
                "Bayra Koisha",
                null
            ],
            [
                null,
                "Kawo Koisha",
                null
            ],
            [
                null,
                "Hobicha",
                null
            ],
            [
                null,
                "Abela Abaya",
                null
            ],
            [
                null,
                "Humbo",
                null
            ],
            [
                null,
                "Damot Gale",
                null
            ],
            [
                null,
                "Damot Woide",
                null
            ],
            [
                null,
                "Ofa",
                null
            ],
            [
                null,
                "Boloso Sore",
                null
            ],
            [
                null,
                "Damot Sore",
                null
            ],
            [
                null,
                "Boloso Bombe",
                null
            ],
            [
                null,
                "Kindo Koisha",
                null
            ],
            [
                null,
                "Kindo Didaye",
                null
            ],
            [
                null,
                "Damot Fulasa",
                null
            ],
            [
                null,
                "Duguna Fango",
                null
            ],
            [
                null,
                " Soddo Zuria",
                null
            ],
            [
                "Kembata Tambaro",
                "Kedida Gamela",
                null
            ],
            [
                null,
                "Kacha Bira",
                null
            ],
            [
                null,
                "Hadero Tunto",
                null
            ],
            [
                null,
                "Adelo",
                null
            ],
            [
                null,
                "Tambaro",
                null
            ],
            [
                null,
                "Doyo Gena",
                null
            ],
            [
                null,
                "Damboya",
                null
            ],
            [
                null,
                "Angacha",
                null
            ],
            [
                "South Omo",
                "Debub Ari",
                null
            ],
            [
                null,
                "Siemen Ari",
                null
            ],
            [
                null,
                "Gnangatom",
                null
            ],
            [
                null,
                "Dasenech",
                null
            ],
            [
                null,
                "Hamer",
                null
            ],
            [
                null,
                "Bena Tsemay",
                null
            ],
            [
                null,
                "Bako Dawula",
                null
            ],
            [
                null,
                "Wub Ari",
                null
            ],
            [
                null,
                "Male",
                null
            ],
            [
                null,
                "Salamago",
                null
            ],
            [
                "Guraghe",
                "Abeshge",
                null
            ],
            [
                null,
                "Kebena",
                null
            ],
            [
                null,
                "Cheha",
                null
            ],
            [
                null,
                "Gumer",
                null
            ],
            [
                null,
                "Geta",
                null
            ],
            [
                null,
                "Izha",
                null
            ],
            [
                null,
                "Inemor",
                null
            ],
            [
                null,
                "Indegagn",
                null
            ],
            [
                null,
                "Soddo",
                null
            ],
            [
                null,
                "Meskan",
                null
            ],
            [
                null,
                "Mareko",
                null
            ],
            [
                null,
                "Misrak Meskan",
                null
            ],
            [
                null,
                "Inemor Ener",
                null
            ],
            [
                null,
                "Debub Soddo",
                null
            ],
            [
                null,
                "Mihur Aklil",
                null
            ],
            [
                null,
                "Gadebano Gutazer Wolene",
                null
            ],
            [
                "Konso",
                "Karat Zuria",
                null
            ],
            [
                null,
                "Segen Zuria",
                null
            ],
            [
                null,
                "Kana",
                null
            ],
            [
                "Gamo",
                "Arba Minch Zuria",
                null
            ],
            [
                null,
                "Mi'Irab Abaya",
                null
            ],
            [
                null,
                "Boreda",
                null
            ],
            [
                null,
                "Kucha",
                null
            ],
            [
                null,
                "Kucha Alpha",
                null
            ],
            [
                null,
                "Deramalo",
                null
            ],
            [
                null,
                "Gerese",
                null
            ],
            [
                null,
                "Bonke",
                null
            ],
            [
                null,
                "Kamba Zuria",
                null
            ],
            [
                null,
                "Garda Marta",
                null
            ],
            [
                null,
                "Chencha Zuria",
                null
            ],
            [
                null,
                "Dita",
                null
            ],
            [
                null,
                "Gacho Baba",
                null
            ],
            [
                null,
                "Kogota",
                null
            ],
            [
                "Konta Special Woreda",
                "Konta",
                null
            ],
            [
                "Burji Special Woreda",
                "Burji",
                null
            ],
            [
                "Basketo Special Woreda",
                "Basketo",
                null
            ],
            [
                "Derashe Special Woreda",
                "Derashe",
                null
            ],
            [
                "Yem Special Woreda",
                "Yem",
                null
            ],
            [
                "Amaro ",
                "Ale",
                null
            ],
            [
                "Ketema Cluster",
                null,
                "  Malka Jabde"
            ],
            [
                null,
                null,
                "  Sabiyan"
            ],
            [
                null,
                null,
                "  Kzira"
            ],
            [
                null,
                null,
                "  Ganda Qore"
            ],
            [
                null,
                null,
                "  Adis Katma"
            ],
            [
                null,
                null,
                "  Qfara"
            ],
            [
                null,
                null,
                "  Afta Esa"
            ],
            [
                null,
                null,
                "  Laghre"
            ],
            [
                null,
                null,
                "  Gandi Greda"
            ],
            [
                "Geter Cluster",
                "Cluster 1",
                "ቢሻን በሄ"
            ],
            [
                null,
                null,
                "አዳዳ"
            ],
            [
                null,
                null,
                "ቢዮአዋሌ"
            ],
            [
                null,
                null,
                "በኬ ሃሎ"
            ],
            [
                null,
                null,
                "አዋሌ"
            ],
            [
                null,
                null,
                "በለዋ"
            ],
            [
                null,
                null,
                "ለገቢራ"
            ],
            [
                null,
                null,
                "ኢጀአነኒ"
            ],
            [
                null,
                null,
                "ቃልቻ"
            ],
            [
                null,
                null,
                "አያሌ ጉምጉም"
            ],
            [
                null,
                null,
                "ኢልሀመር"
            ],
            [
                null,
                null,
                "ኮርቱ"
            ],
            [
                null,
                "Cluster 2",
                "ጀሎ በሊና"
            ],
            [
                null,
                null,
                "ሀርላ"
            ],
            [
                null,
                null,
                "  ለገኦዳ ሚርጋ"
            ],
            [
                null,
                null,
                "  ዋሂል "
            ],
            [
                null,
                null,
                "  ዱጁማ"
            ],
            [
                null,
                null,
                "   ኮሪሶ"
            ],
            [
                null,
                null,
                "  ለገኦዳ ጉኑፈታ"
            ],
            [
                null,
                null,
                "ሀሎ ቡሳ"
            ],
            [
                null,
                null,
                "   ሁሉል ሞጆ"
            ],
            [
                null,
                "Cluster 3",
                null
            ],
            [
                null,
                null,
                "    ሁላሁሉል"
            ],
            [
                null,
                null,
                " አዲጋ ፈለማ. "
            ],
            [
                null,
                null,
                "      ገንደ ሪጌ"
            ],
            [
                null,
                null,
                "   ጎለ አዴግ"
            ],
            [
                null,
                null,
                "       ቦረን ጄደን"
            ],
            [
                null,
                null,
                "      ገዳንሳር"
            ],
            [
                null,
                null,
                "       ገንደ ገበሬ"
            ],
            [
                null,
                null,
                "    አሰሊሶ"
            ],
            [
                null,
                null,
                "      ጀልዴሳ"
            ],
            [
                null,
                "Cluster 4",
                " ገርባ አነኖ"
            ],
            [
                null,
                null,
                " ጪሪ ሚቲ"
            ],
            [
                null,
                null,
                " ሙዲ አነኖ"
            ],
            [
                null,
                null,
                " ለገዲኒ"
            ],
            [
                null,
                null,
                "  መልካ ቀሮ"
            ],
            [
                null,
                null,
                " ደቤሌይ"
            ],
            [
                null,
                null,
                "ኩላዩ"
            ],
            [
                null,
                null,
                " ለገዶል"
            ],
            [
                "Zone 1",
                "Elidar",
                null
            ],
            [
                null,
                "Asaita",
                null
            ],
            [
                null,
                "Afambo",
                null
            ],
            [
                null,
                "Mille",
                null
            ],
            [
                null,
                "Chifra",
                null
            ],
            [
                "Zone 2",
                "Afdera",
                null
            ],
            [
                null,
                "Erebti",
                null
            ],
            [
                null,
                "Abala",
                null
            ],
            [
                null,
                "Magalie",
                null
            ],
            [
                "Zone 3",
                "Awash Fentale",
                null
            ],
            [
                null,
                "Dulesa",
                null
            ],
            [
                null,
                "Bure Madaytu",
                null
            ],
            [
                null,
                "Gewane",
                null
            ],
            [
                null,
                "Amibara",
                null
            ],
            [
                null,
                "Haruka",
                null
            ],
            [
                "Zone 4",
                "Teru",
                null
            ],
            [
                null,
                "Yalo",
                null
            ],
            [
                null,
                "Gulina",
                null
            ],
            [
                null,
                "Ewa",
                null
            ],
            [
                null,
                "Awra",
                null
            ],
            [
                "Zone 5",
                "Dawe",
                null
            ],
            [
                null,
                "Telalak",
                null
            ],
            [
                null,
                "Dalifage",
                null
            ],
            [
                null,
                "Simurobi Gele'Alo",
                null
            ],
            [
                null,
                "Adile Ela",
                null
            ]
        ];
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
        dd('Woreda Imported successfully');
    }
}
