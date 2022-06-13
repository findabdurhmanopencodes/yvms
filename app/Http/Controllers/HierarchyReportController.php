<?php

namespace App\Http\Controllers;

use App\Models\HierarchyReport;
use App\Http\Requests\StoreHierarchyReportRequest;
use App\Http\Requests\UpdateHierarchyReportRequest;
use App\Models\TrainingSession;

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
    public function show(HierarchyReport $hierarchyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function edit(HierarchyReport $hierarchyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHierarchyReportRequest  $request
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHierarchyReportRequest $request, HierarchyReport $hierarchyReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HierarchyReport  $hierarchyReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession,HierarchyReport $hierarchy)
    {
        $hierarchy->delete();
        return redirect()->back()->with('message','Report deleted successfully');
    }
}
