<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollSheetRequest;
use App\Http\Requests\UpdatePayrollSheetRequest;
use App\Models\PayrollSheet;

class PayrollSheetController extends Controller
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
     * @param  \App\Http\Requests\StorePayrollSheetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayrollSheetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PayrollSheet  $payrollSheet
     * @return \Illuminate\Http\Response
     */
    public function show(PayrollSheet $payrollSheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayrollSheet  $payrollSheet
     * @return \Illuminate\Http\Response
     */
    public function edit(PayrollSheet $payrollSheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayrollSheetRequest  $request
     * @param  \App\Models\PayrollSheet  $payrollSheet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayrollSheetRequest $request, PayrollSheet $payrollSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayrollSheet  $payrollSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayrollSheet $payrollSheet)
    {
        //
    }
}
