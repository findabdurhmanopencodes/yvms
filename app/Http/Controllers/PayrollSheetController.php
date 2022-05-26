<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollSheetSheetRequest;
use App\Http\Requests\UpdatePayrollSheetRequest;
use App\Http\Requests\UpdatePayrollSheetSheetRequest;
use App\Models\Payroll;
use App\Models\PayrollSheet;
use App\Models\PayrollSheetSheet;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Woreda;
use App\Models\PaymentType;
use App\Models\Volunteer;
use App\Models\Zone;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LDAP\Result;

class PayrollSheetController extends Controller
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

    public function index(Request $request,Payroll $payroll_id)
    {

      //  $payroll_sheets = PayrollSheet::whereRelation('payroll_sheets','training_centers','training_sessions','payroll_id',1)->paginate(10);
       // $payrollsheets = PayrollSheet::with('payrollSheets.payroll')->find($payroll_id);
         $training_centers = TraininingCenter::all();
         $training_sessions = TrainingSession::all();
         $payroll_sheets = PayrollSheet::orderBy('id', 'Desc')->Paginate(10);
        // $payrollcode = PayrollSheet::whereRelation('id',$payroll_id);


       return view('payrollSheet.index', compact(['payroll_sheets','training_centers','training_sessions']));
        //return view('payrollSheet.index', compact('payroll_sheets'));
    }


    public function payee(Request $request)
    {
        // $trainingSession = TrainingSession::availableSession()->first();

        // $q = TrainingPlacement::query()->where('training_placements.training_session_id', $trainingSession->id);

        // if ($request->get('payment') != null and $request->get('payment')=='fixed') {
        //     $q->whereHas('approvedApplicant.volunteer.woreda.zone.region', function ($query) use ($request) {
        //         $query->where('id', $request->get('region'));
        //     });
        // }
        // if ($request->get('transport') != null and $request->get('transport')=='transport') {
        //     $q->whereHas('approvedApplicant.volunteer.woreda.zone', function ($query) use ($request) {
        //         $query->where('id', $request->get('zone'));
        //     });
        // }
        // if ($request->get('mothly') != null and $request->get('monthly')=='monthly') {
        //     $q->whereHas('approvedApplicant.volunteer.woreda', function ($query) use ($request) {
        //         $query->where('id', $request->get('woreda'));
        //     });
        // }

        $placedVolunteers = Volunteer::all();

        //$placedVolunteers = $q->paginate(10);

        return view('payrollSheet.trainee_list', [
            'placedVolunteers' => $placedVolunteers,
            'payment_types' =>PaymentType::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          // creating eduycational level setting
          return view('payrollSheet.create');

    }
    public function store(Request $request)
    {

        $payroll_sheet = new PayrollSheet();
        $payroll_sheet->payroll_id= 1;
        $payroll_sheet->trainining_center_id = $request->training_center;
        $payroll_sheet->training_session_id = TrainingSession::availableSession()->last()->id;
        $payroll_sheet->user_id=Auth::user()->id;
        $payroll_sheet ->save();
//   //if ($request->has('training_center')) {
//               PayrollSheet::create([
//               'payroll_id'=>1,
//               'trainining_center_id'=>$request->training_center,
//               'training_session_id'=>TrainingSession::availableSession()->last()->id,
//               'user_id'=>Auth::user()->id]);
//      //   }

          return redirect()->route('payrollSheet.index')->with('message', 'PayrollSheet created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PayrollSheet  $payrollsheet
     * @return \Illuminate\Http\Response
     */
    public function show(PayrollSheet $payrollsheet_id)
    {
        return view('payrollSheet.show', [
            'PayrollSheet' =>PayrollSheet::findOrFail($payrollsheet_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayrollSheet  $payrollsheet
     * @return \Illuminate\Http\Response
     */
    public function edit(PayrollSheet $payrollsheet)
    {
        return view('payrollsheet.edit',compact('payrollsheet'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayrollSheetRequest  $request
     * @param  \App\Models\PayrollSheet  $payrollsheet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayrollSheetRequest $request, PayrollSheet $payrollsheet)
    {
        $data = $request->validate(['name' => 'required|string|unique:payrollsheets,name,'.$payrollsheet->id]);
        $payrollsheet->update($data);
        return redirect()->route('payrollsheet.index')->with('message', 'PayrollSheet updated successfully');
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayrollSheet  $payrollsheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,PayrollSheet $payrollsheet)
    {
        $payrollsheet->delete();
        if ($request->ajax()) {
            return response()->json(array('message' => 'deleted successfully'), 200);
        }
    }
}
