<?php

namespace App\Http\Controllers;

use App\Models\HierarchyReport;
use App\Http\Requests\StoreHierarchyReportRequest;
use App\Http\Requests\UpdateHierarchyReportRequest;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\Woreda;
use App\Models\Zone;

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
        $data = $request->validated();
        HierarchyReport::create($data);
        return redirect()->back()->with('message','Hierarchical report created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSession $trainingSession,HierarchyReport $hierarchy)
    {
        return view('hierarchy_report.show',compact('hierarchy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingSession $trainingSession,HierarchyReport $hierarchy)
    {
        $reportableType= $hierarchy->reportable instanceof Woreda?Woreda::class:($hierarchy->reportable instanceof Zone?Zone::class:Region::class);
        return view('hierarchy_report.edit',compact('trainingSession','hierarchy','reportableType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHierarchyReportRequest  $request
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHierarchyReportRequest $request,TrainingSession $trainingSession, HierarchyReport $hierarchy)
    {
        $data = $request->validated();
        unset($data['reportable_type']);
        unset($data['reportable_id']);
        $hierarchy->update($data);
        return redirect()->route('session.hierarchy.show',['training_session'=>$trainingSession->id,'hierarchy'=>$hierarchy->id])->with('message','Hirearchy message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession,HierarchyReport $hierarchy)
    {
        $reportable = $hierarchy->reportable;
        $hierarchy->delete();
        if($reportable instanceof Woreda){
            $woreda = $reportable;
            return redirect()->route('session.deployment.woreda.detail',['training_session'=>$trainingSession->id,'woreda'=>$woreda])->with('message','Report deleted successfully');
        }

        if($reportable instanceof Zone){
            $zone = $reportable;
            return redirect()->route('session.deployment.zone.woredas',['training_session'=>$trainingSession->id,'zone'=>$zone->id])->with('message','Report deleted successfully');
        }

        if($reportable instanceof Region){
            $region = $reportable;
            return redirect()->route('session.deployment.region.zones',['training_session'=>$trainingSession->id,'region'=>$region->id])->with('message','Report deleted successfully');
        }
        return redirect()->back()->with('message','Report deleted successfully');
    }
}
