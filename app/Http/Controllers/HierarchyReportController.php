<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\HierarchyReport;
use App\Http\Requests\StoreHierarchyReportRequest;
use App\Http\Requests\UpdateHierarchyReportRequest;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\UserRegion;
use App\Models\Woreda;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class HierarchyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreHierarchyReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHierarchyReportRequest $request)
    {
        if (!Auth::user()?->can('HierarchyReport.store'))
            return abort(403);
        $user = Auth::user();
        $data = $request?->validated();
        if ($data['reportable_type'] == Woreda::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $woreda = Woreda::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $woreda?->zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $woreda?->zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Zone::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $zone = Zone::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Region::class) {
            if ($user?->hasAnyRole([Constants::REGIONAL_COORDINATOR])) {
                $region = Region::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Region::class)?->where('levelable_id', $region?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $region?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else {
            return abort(403);
        }
        HierarchyReport::create($data);
        return redirect()?->back()?->with('message', 'Hierarchical report created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSession $trainingSession, HierarchyReport $hierarchy)
    {
        if (!Auth::user()?->can('HierarchyReport.show'))
            return abort(403);
        $user = Auth::user();
        if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
            $item = $hierarchy?->reportable;
            if (get_class($item) == Woreda::class)
                $item = $item?->zone;
            $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $item?->id)?->first();
            $item = $userRegion?->levelable;
            if ($userRegion?->levelable == null) {
                return abort(404);
            }
        } else if ($user?->hasAnyRole([Constants::REGIONAL_COORDINATOR])) {
            $item = $hierarchy?->reportable;
            if (get_class($item) == Zone::class)
                $item = $item?->region;
            if (get_class($item) == Woreda::class)
                $item = $item?->zone?->region;
            $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Region::class)?->where('levelable_id', $item?->id)?->first();
            $item = $userRegion?->levelable;
            if ($userRegion?->levelable == null) {
                return abort(404);
            }
        }
        return view('hierarchy_report.show', compact('hierarchy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingSession $trainingSession, HierarchyReport $hierarchy)
    {
        if (!Auth::user()?->can('HierarchyReport.update'))
            return abort(403);
        $user = Auth::user();
        $data = ['reportable_type'=> get_class($hierarchy?->reportable),'reportable_id'=>$hierarchy?->reportable_id];
        if ($data['reportable_type'] == Woreda::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $woreda = Woreda::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $woreda?->zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $woreda?->zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Zone::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $zone = Zone::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Region::class) {
            if ($user?->hasAnyRole([Constants::REGIONAL_COORDINATOR])) {
                $region = Region::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Region::class)?->where('levelable_id', $region?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $region?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else {
            return abort(403);
        }
        $reportableType = $hierarchy?->reportable instanceof Woreda ? Woreda::class : ($hierarchy?->reportable instanceof Zone ? Zone::class : Region::class);
        return view('hierarchy_report.edit', compact('trainingSession', 'hierarchy', 'reportableType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHierarchyReportRequest  $request
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHierarchyReportRequest $request, TrainingSession $trainingSession, HierarchyReport $hierarchy)
    {
        if (!Auth::user()?->can('HierarchyReport.update'))
            return abort(403);
        $user = Auth::user();
        $data = $request?->validated();
        if ($data['reportable_type'] == Woreda::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $woreda = Woreda::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $woreda?->zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $woreda?->zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Zone::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $zone = Zone::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item->id != $zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Region::class) {
            if ($user?->hasAnyRole([Constants::REGIONAL_COORDINATOR])) {
                $region = Region::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Region::class)?->where('levelable_id', $region?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $region?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else {
            return abort(403);
        }
        $data = $request?->validated();
        unset($data['reportable_type']);
        unset($data['reportable_id']);
        $hierarchy?->update($data);
        return redirect()?->route('session.hierarchy.show', ['training_session' => $trainingSession?->id, 'hierarchy' => $hierarchy?->id])?->with('message', 'Hirearchy message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession, HierarchyReport $hierarchy)
    {
        if (!Auth::user()?->can('HierarchyReport.destroy'))
            return abort(403);
        $user = Auth::user();
        $data = ['reportable_type'=> get_class($hierarchy?->reportable),'reportable_id'=>$hierarchy?->reportable_id];
        if ($data['reportable_type'] == Woreda::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $woreda = Woreda::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $woreda?->zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $woreda?->zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Zone::class) {
            if ($user?->hasAnyRole([Constants::ZONE_COORDINATOR])) {
                $zone = Zone::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Zone::class)?->where('levelable_id', $zone?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $zone?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        } else if ($data['reportable_type'] == Region::class) {
            if ($user?->hasAnyRole([Constants::REGIONAL_COORDINATOR])) {
                $region = Region::find($data['reportable_id']);
                $userRegion = UserRegion::where('user_id', $user?->id)?->where('levelable_type', Region::class)?->where('levelable_id', $region?->id)?->first();
                $item = $userRegion?->levelable;
                if ($userRegion?->levelable == null) {
                    return abort(404);
                }
                if ($item?->id != $region?->id)
                    return abort(403);
            } else {
                return abort(403);
            }
        }
        $reportable = $hierarchy?->reportable;
        $hierarchy?->delete();
        if ($reportable instanceof Woreda) {
            $woreda = $reportable;
            return redirect()?->route('session.deployment.woreda.detail', ['training_session' => $trainingSession?->id, 'woreda' => $woreda])?->with('message', 'Report deleted successfully');
        }

        if ($reportable instanceof Zone) {
            $zone = $reportable;
            return redirect()?->route('session.deployment.zone.woredas', ['training_session' => $trainingSession?->id, 'zone' => $zone?->id])?->with('message', 'Report deleted successfully');
        }

        if ($reportable instanceof Region) {
            $region = $reportable;
            return redirect()?->route('session.deployment.region.zones', ['training_session' => $trainingSession?->id, 'region' => $region?->id])?->with('message', 'Report deleted successfully');
        }
        return redirect()?->back()?->with('message', 'Report deleted successfully');
    }
}
