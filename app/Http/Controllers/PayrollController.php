<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollRequest;
use App\Http\Requests\UpdatePayrollRequest;
use App\Models\Payroll;
use Illuminate\Http\Request;

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

        $payrolls = Payroll::all();
        return view('payroll.index', compact('payrolls'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePayrollRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayrollRequest $request)
    {
        {
            $request->validate(['name' => 'required|string|unique:educational_levels,name']);
            Payroll::create(['name' => $request->get('name')]);
            return redirect()->route('payroll.index')->with('message', 'Payroll created successfully');
        }
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
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
