<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentReportRequest;
use App\Http\Requests\UpdatePaymentReportRequest;
use App\Models\PaymentReport;
use App\Models\Payroll;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PaymentReportController extends Controller
{

    public function __construct()
    {

        $this->authorizeResource(PaymentReport::class,'paymentReport');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(PaymentReport::select())->make(true);

        }
        $training_sessions = TrainingSession::orderBy('id', 'desc')->paginate(1);
        $training_centers = TraininingCenter::orderBy('id', 'desc')->paginate(10);
        $payment_reports = PaymentReport::orderBy('id', 'desc')->Paginate(10);
        // $paymentReports = PaymentReport::all();

        return view('payrollSheet.payment_report', compact('payment_reports','training_sessions','training_centers'));
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
     * @param  \App\Http\Requests\StorePaymentReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentReport  $paymentReport
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentReport $paymentReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentReport  $paymentReport
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentReport $paymentReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentReportRequest  $request
     * @param  \App\Models\PaymentReport  $paymentReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentReportRequest $request, PaymentReport $paymentReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentReport  $paymentReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentReport $paymentReport)
    {
        //
    }
}
