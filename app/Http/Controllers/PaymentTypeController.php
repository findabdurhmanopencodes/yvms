<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentTypeRequest;
use App\Http\Requests\UpdatePaymentTypeRequest;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{


    public function __construct()
    {

        $this->authorizeResource(PaymentType::class,'paymentType');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(PaymentType::select())->make(true);
        }

       $paymentTypes = PaymentType::all();
        return view('paymentType.index', compact('paymentTypes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           // creating eduycational level setting
           return view('paymentType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentTypeRequest $request)
    {

        $request->validate(['name' => 'required|string|unique:payment_types,name']);

        PaymentType::create([

            'name' => $request->get('name'),
            'amount'=>$request->get('amount')]);

      return redirect()->route('paymentType.index')->with('message', 'payment type created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymentType)
    {
        $paymentTypes = PaymentType::find($paymentType);
        return view('paymentType.edit', compact('paymentTypes'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentTypeRequest  $request
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentTypeRequest $request, PaymentType $paymentType){

        $data =  $request->validate(['name' => 'required|string|unique:payment_types,name']);

        $paymentType->update($data);
        return redirect()->route('resource.index')->with('message', 'payment type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,PaymentType $paymentType)
    {
        $paymentType->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
