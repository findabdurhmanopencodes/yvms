<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollRequest;
use App\Http\Requests\UpdatePayrollRequest;
use App\Models\Payroll;
use App\Models\TrainingSession;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        // $this->authorizeResource(Payroll::class,'Payroll');

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Payroll::select())->make(true);

        }
        $last_sessions = TrainingSession::orderBy('id', 'desc')->paginate(1);
        $training_sessions = TrainingSession::orderBy('id', 'desc')->paginate(30);
         $payrolls = Payroll::orderBy('id', 'desc')->Paginate(1);

        return view('payroll.index', compact('payrolls','training_sessions','last_sessions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          // creating eduycational level setting
          return view('payroll.create');

    }
    public function store()
    {

       // dd('hello');
         //   $request->validate(['name' => 'required|string|unique:payrols,name']);
             $traingSession     = TrainingSession::availableSession()->last();
             $prefix ='MoP-YVMS-Payroll';
             $current_year =now()->year;
             $code   = $prefix ."-".$traingSession->id."-".$current_year;

             Payroll::create(['name'=>$code,
             'training_session_id'=>$traingSession->id,
             'user_id'=>Auth::user()->id]);

          return redirect()->route('payroll.index')->with('message', 'Payroll created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll_id)
    {
        return view('payroll.show', [
            'Payroll' =>Payroll::findOrFail($payroll_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        return view('payroll.edit',compact('payroll'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayrollRequest  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayrollRequest $request, Payroll $payroll)
    {
        $data = $request->validate(['name' => 'required|string|unique:payrolls,name,'.$payroll->id]);
        $payroll->update($data);
        return redirect()->route('payroll.index')->with('message', 'Payroll updated successfully');
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Payroll $payroll)
    {
        $payroll->delete();
        if ($request->ajax()) {
            return response()->json(array('message' => 'deleted successfully'), 200);
        }
    }
}
