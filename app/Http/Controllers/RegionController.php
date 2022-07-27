<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Region;
use App\Models\Zone;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\ImporterFiles;
use App\Models\HierarchyReport;
use App\Models\Qouta;
use App\Models\RegionIntake;
use App\Models\TrainingSession;
use App\Models\UserRegion;
use App\Models\Woreda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function __construct()
    {

        // $this->authorizeResource(Region::class, 'region');
    }
    protected function resourceAbilityMap()
    {
        return [
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'place' => 'place',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('Region.index')){
            return abort(403);
        }
        $trainingSession_id = TrainingSession::availableSession()?->first()?->id;
        if ($request->ajax()) {
            return datatables()->of(Region::select())->make(true);
        }

        $regions = Region::all();
        return view('region.index', compact('regions', 'trainingSession_id'));
    }

    public function place(Request $request)
    {

        $regions = Region::all();
        return view('region.placement', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('Region.store')){
            return abort(403);
        }
        return view('region.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionRequest $request)
    {
        if(!Auth::user()->can('Region.store')){
            return abort(403);
        }
        $regionInquota = $request->get('region_quota') / 100;
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'code' => 'required|string|unique:permissions,name'
        ]);
        Region::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'qoutaInpercent' => $regionInquota, 'status' => 1]);
        return redirect()->route('region.index')->with('message', 'Region created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('Region.update')){
            return abort(403);
        }
        $regions = Region::find($id);
        return view('region.edit', compact('regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegionRequest  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegionRequest $request, $id)
    {
        if(!Auth::user()->can('Region.update')){
            return abort(403);
        }
        $region = Region::find($id);
        $region->name = $request->get('name');
        $region->code = $request->get('code');

        $region->qoutaInpercent = $request->get('qoutaInpercent') / 100;
        if ($request->get('status')) {
            if ($request->get('status') == 'on') {
                $region->status = 1;
            } else {
                $region->status = 0;
                foreach ($region->zones as $key => $zon) {
                    $zone = Zone::find($zon->id);
                    $zone->status = 0;
                    $zone->save();
                    foreach ($zon->woredas as $key => $wor) {
                        $woreda = Woreda::find($wor->id);
                        $woreda->status = 0;
                        $woreda->save();
                    }
                }
            }
        } else {
            $region->status = 0;
            foreach ($region->zones as $key => $zon) {
                $zone = Zone::find($zon->id);
                $zone->status = 0;
                $zone->save();
                foreach ($zon->woredas as $key => $wor) {
                    $woreda = Woreda::find($wor->id);
                    $woreda->status = 0;
                    $woreda->save();
                }
            }
        }
        $region->save();
        return redirect()->route('region.index')->with('message', 'Region edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Region $region)
    {
        if(!Auth::user()->can('Region.destroy')){
            return abort(403);
        }
        // foreach ($region->zones as $zone) {
        //     $zone->delete();
        // }
        $region->delete();
        // if ($request->ajax()) {
        return response()->json(array('msg' => 'deleted successfully'));
        // }
    }

    public function validateForm(Region $region, Request $request)
    {
        $limit = false;
        $reg = $region::all();
        $sum = $request->qouta;
        foreach ($reg as $key => $value) {
            $a = $value->qoutaInpercent * 100;
            $sum += $a;
        }
        $sum = ($sum - $request->prv_val) / 100;

        if ($sum <= 1) {
            $limit = true;
        }

        return response()->json(['limit' => $limit]);
    }

    public function regionIntake(TrainingSession $trainingSession, $region_id)
    {
        if (!Auth::user()->can('RegionIntake.index')) {
            return abort(403);
        }
        $today = Carbon::today();
        $curr_sess = TrainingSession::where('start_date', '<=', $today)->where('end_date', '>=', $today)->get();
        $intake_exist = RegionIntake::where('training_session_id', $trainingSession->id)->where('region_id', $region_id)->get();
        $region = Region::where('id', $region_id)?->get()[0];
        return view('region.region_capacity', compact('region', 'trainingSession', 'intake_exist', 'curr_sess'));
    }

    public function regionIntakeStore(Request $request, TrainingSession $trainingSession, $region_id)
    {
        if (!Auth::user()->can('RegionIntake.store')) {
            return abort(403);
        }
        RegionIntake::create(['training_session_id' => $trainingSession->id, 'region_id' => $region_id, 'intake' => $request->get('capacity')]);
        return redirect()->route('session.region.intake', ['training_session' => $trainingSession->id, 'region_id' => $region_id])->with('message', 'Region created successfully');
    }
    public function regionIntakeEdit(TrainingSession $trainingSession, $region_id){
        $regions = Region::find($region_id);
        $regionIntake = $regions->regionIntakes->last();
        return view('region.regionIntake', compact('regionIntake', 'regions', 'trainingSession'));
    }
    public function regionIntakeUpdate(Request $request, TrainingSession $trainingSession, $region_id){
        $regions = Region::find($region_id);
        $regionIntake = $regions->regionIntakes->last();
        $regionIntake->intake = $request->get('capacity');
        $regionIntake->save();
        return redirect()->route('session.region.intake', ['training_session' => $trainingSession->id, 'region_id' => $region_id])->with('message', 'Region Intake updated successfully');
    }
    public function import()
    {
        dd('none');
        $binRegions =  ImporterFiles::REGION_IMPORTS;
        $totalRegions = 0;
        foreach ($binRegions as $region) {
            $region = $region[0];
            Region::where('name', $region)->firstOr(function () use ($region,&$totalRegions) {
                Region::create(['name' => $region, 'status' => 0]);
                $totalRegions++;
            });
        }
        dump($totalRegions . ' Region imported successfully');
        // $binRegions = ImporterFiles::REGION_IMPORTS;
        // function filter($var)
        // {
        //     return $var !== NULL && $var !== FALSE && $var !== '' && $var !== "";
        // }
        // $regions = [];
        // foreach ($binRegions as $bin) {
        //     $filterResult = filter($bin[0]);
        //     if ($filterResult) {
        //         array_push($regions, $bin[0]);
        //     }
        // }
        // foreach ($regions as $region) {
        //     Region::where('name', $region)->firstOr(function () use ($region) {
        //         Region::create(['name' => $region, 'status' => 0]);
        //     });
        // }
        // dd('Region Imported successfully');
    }

    public function deployment(TrainingSession $trainingSession)
    {
        $user = Auth::user();
        if($user->canany(['HierarchyReport.list']) && !$user->hasRole(Constants::SUPER_ADMIN) && !$user->hasRole('HierarchyReport.index') ){
            if($user->hasRole(Constants::ZONE_COORDINATOR)){
                $userRegion = UserRegion::where('user_id',$user->id)->where('levelable_type',Zone::class)->first();
                if($userRegion->levelable==null){
                    return abort(404);
                }
                return redirect(route('session.deployment.zone.woredas',['training_session'=>$trainingSession->id,'zone'=>$userRegion->levelable]));
            }else if($user->hasRole(Constants::REGIONAL_COORDINATOR)){
                $userRegion = UserRegion::where('user_id',$user->id)->where('levelable_type',Region::class)->first();
                $region = $userRegion->levelable;
                if($region == null){
                    return abort(404);
                }
                return redirect(route('session.deployment.region.zones',['training_session'=>$trainingSession->id,'region'=>$region->id]));
            }
            else{
                return abort(403,'You did not have role');
            }
        }else if(!$user->canany(['HierarchyReport.index'])){
            return abort(403);
        }
        $quota = Qouta::with('quotable')->where('training_session_id', $trainingSession->id)->where('quotable_type', Region::class)->pluck('quotable_id');
        if (Auth::user()->roles()->get()->first()->name == 'regional-coordinator') {
            $regions = Region::with(['zones', 'quotas'])->whereIn('id', $quota)->where('id',Auth::user()->getCordinatingRegion()->id)->get();
        }else{
            $regions = Region::with(['zones', 'quotas'])->whereIn('id', $quota)->get();
        }
        return view('training_session.regions', compact('trainingSession', 'regions'));
    }
}
