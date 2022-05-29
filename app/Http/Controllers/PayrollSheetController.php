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
use Andegna\DateTimeFactory;
use App\Models\Volunteer;
use App\Models\Zone;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LDAP\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
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

       return view('payrollSheet.index', compact(['payroll_sheets',
       'training_centers','training_sessions']));
        //return view('payrollSheet.index', compact('payroll_sheets'));
    }

    public function generatePDF( Request $request) {

             $placedVolunteers = Volunteer::all();
             $paymentTypes  = PaymentType::where('id',1)->first();
             $year = '2014';
             $date = DateTimeFactory::fromDateTime(new Carbon('now'))->format('d/m/Y h:i:s');
             $title = 'Trainee  payroll Payment report';
             $session = 'MoP-YVMS-01-2014';
             $center ='Jimma University';

             if ( $request->get('payment_type')=='fixed') {

                // write here code to generate  pocket meoney for trainee
              }

             elseif ($request->get('payment_type')=='transport') {
                  // write here location based payment betwwen zone and training center in kemeter
             }
               else{

                 }

            if ($request->get('format') != null and $request->get('format')=='pdf') {
            $pdf = PDF::loadView('payrollSheet.myPDF', compact('placedVolunteers','title','paymentTypes','session','center'))->setPaper('a4', 'landscape');
            return $pdf->download('payroll'.$year.'pdf');
              }
           else{
            return redirect()->route('payrollSheet.index')->with('message', 'Sorry currently We have no Ms exceel file');

        }


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

        $total_volunteers = DB::table('volunteers')->count();
        
        $placedVolunteers = Volunteer::all();
        $PaymentType  = PaymentType::where('id',1)->first();
        return view('payrollSheet.trainee_list', [
            'placedVolunteers' => $placedVolunteers,
            'PaymentType' =>$PaymentType,
            'total_vol'=>   $total_volunteers,
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
