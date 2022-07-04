<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollSheetSheetRequest;
use App\Http\Requests\UpdatePayrollSheetRequest;
use App\Http\Requests\UpdatePayrollSheetSheetRequest;
use App\Models\Payroll;
use App\Models\PayrollSheet;
use App\Models\TransportTarif;
use App\Models\PayrollSheetSheet;
use App\Models\Region;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Woreda;
use App\Models\PaymentType;
use App\Constants;
use Andegna\DateTimeFactory;
use App\Models\Distance;
use App\Models\Volunteer;
use App\Models\ApprovedApplicant;
use App\Models\PaymentReport;
use App\Models\Status;
use App\Models\Zone;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LDAP\Result;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use GuzzleHttp\TransferStats;

class PayrollSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

         $this->authorizeResource(Payroll::class,'Payroll');

    }

    public function index(Payroll $payroll, Request $request)
    {
      //  $trainingSession_id = TrainingSession::availableSession()[0]->id;
        if ($request->ajax()) {
            return datatables()->of(PayrollSheet::select())->addColumn('payroll', function (PayrollSheet $payrollSheet) {
                return $payrollSheet->payroll->name;
            })->make(true);
        }
     //   $payroll_sheets=  PayrollSheet::findOrFail($payroll);
        $training_centers = TraininingCenter::all();
        $training_sessions = TrainingSession::all();
        $payroll_sheets = PayrollSheet::orderBy('id', 'desc')->Paginate(10);
        return view('payrollSheet.index', compact('payroll_sheets','payroll','training_centers', 'training_sessions'));

    }

    public function payroll_list($payroll_id){


       $payroll=  Payroll::findOrFail($payroll_id);

        $training_centers = TraininingCenter::all();
        $training_sessions = TrainingSession::all();
        $payroll_sheets = PayrollSheet::select('*')->where('payroll_id', '=',$payroll_id)->paginate(10);
        return view('payrollSheet.index', compact('payroll_sheets','training_centers','payroll', 'training_sessions'));

    }

    public function calculate($zone_id, $traingCenter_id)
    {
          $result = 0.0;
          $distance  = Distance::select('km')->where('zone_id', '=', $zone_id)->where('trainining_center_id', '=', $traingCenter_id)->get()->last();
          $tarif = TransportTarif::select('price')->get()->last()->price;

          if ($distance==null) {
                $result = 0;
            }
            else{
                $result =  $distance->km  * $tarif;
            }


        return  $result;
    }



    public function getKm($zone_id, $traingCenter_id)
    {
          $result = 0;
          $distance  = Distance::select('km')->where('zone_id', '=', $zone_id)->where('trainining_center_id', '=', $traingCenter_id)->get()->last();

          if ($distance==null) {
                $km = 0;
            }
            else{
                $km =  $distance->km;
            }


        return  $km;
    }



       public function getPayee($training_session_id,$trainining_center_id){

        $results = [];
        $results = Volunteer::whereRelation('status','acceptance_status', Constants:: VOLUNTEER_STATUS_CHECKEDIN)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainining_center_id)->whereRelation('approvedApplicant', 'training_session_id', $training_session_id)->get();

        return $results;

      }

    public function generatePDF(Request $request)
    {


         $tarif = TransportTarif::select('price')->get()->last()->price;
         $km = [];
        $paymentTypes  = PaymentType::where('id', 1)->first();
         $date = DateTimeFactory::fromDateTime(new Carbon('now'))->format('d/m/Y h:i:s');

        $traingSession     = TrainingSession::availableSession()->first();
        $prefix ='MoP-YVMS-Payroll';
        $current_year = now()->year;
        $code   = $prefix ."-".$traingSession->id."-".$current_year;

        $title = 'Trainee  payroll Payment report';
        $session = $prefix ."-".$traingSession->id."-".$current_year;
        $center = 'Name';

        $year = Carbon::now()->format('Y');
        $date =  DateTime::createFromFormat('d/m/Y', $request->get('sdate'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        //$date = Carbon::now();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();

        $sdate =  $dob_GC;
        $newDate = $sdate->format('d/m/Y');

        $start_date = Carbon::createFromFormat('d/m/Y',  $newDate);
        $edate  = $start_date->addDays($day);

        $day = $request->get('day');

        $volunteers = Volunteer::whereRelation('status','acceptance_status', Constants:: VOLUNTEER_STATUS_CHECKEDIN)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->get();


           foreach ($volunteers  as $key => $value) {
            $center=$value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->get()->first();
             }


   ///////////////////////////////////////////////////////////////////////////////
        if ($request->get('payment_type') == '1' ) {  // for monthly  money payment
             $fixedAmount = PaymentType::where('id', 1)->first();
            $placedVolunteers = Volunteer::whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_DEPLOYED)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->get();
            $total_volunteers = Volunteer::whereRelation('status','acceptance_status',  Constants::VOLUNTEER_STATUS_DEPLOYED)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->count();


            ////////// to count total payable volunteers /////////
            $total =0;
            foreach ($placedVolunteers as $placedVolunteer) {
            $total = $total+1;
            }
               $payment= PaymentReport::create([
                    'trainining_center_id' =>$center->id,
                    'training_session_id' =>$traingSession->id,
                    'payment_type_id'=>1,
                    'user_id'=>Auth::user()->id,
                    'status'=>1,
                    'approved_by '=>null,
                    'total_amount'=>$fixedAmount , // to get monthly payment
                    'total_payee'=>$total
                ]);

               if(!$payment->save()){
                    return redirect()->route('payrollSheet.index')->with('error', 'Report not successfull!');
                }

            if ($request->get('format') != null and $request->get('format') == 'pdf') {
                $pdf = PDF::loadView('payrollSheet.pocket_money_pdf', compact(
                    'placedVolunteers',
                    'title',
                    'paymentTypes',
                    'session',
                    'center',
                    'total_volunteers',
                    'sdate',
                    'edate',
                    'day',
                    'tarif'
                ))->setPaper('A4', 'landscape');
                return $pdf->download('payroll' . $year . 'pdf');
            } else {
                return redirect()->route('payrollSheet.index')->with('message', 'Sorry currently We have no Ms exceel file');
            }
        }

        elseif ($request->get('payment_type') == '2') { // for perdiem payment
            $placedVolunteers = Volunteer::whereRelation('status','acceptance_status', Constants:: VOLUNTEER_STATUS_CHECKEDIN)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->get();
            $total_volunteers = Volunteer::whereRelation('status','acceptance_status', Constants:: VOLUNTEER_STATUS_CHECKEDIN)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->count();

            $totals = [];
            $scale = [];

            foreach ($placedVolunteers as $key => $value) {

                array_push($totals, $this->calculate($value->woreda->zone->id,  $value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->id));
                array_push($scale,$value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->scale);

                  }
           $total =0;
            foreach ($placedVolunteers as $placedVolunteer) {
            $total = $total+1;

            }

            $payment= PaymentReport::create([
                'trainining_center_id' =>$center->id,
                'training_session_id' =>$traingSession->id,
                'payment_type_id'=>2,
                'user_id'=>Auth::user()->id,
                'total_amount'=>0,
                'status'=>1,
                'approved_by '=>null,
                'scale'=>  $scale,
                'total_payee'=>$total
            ]);

           if(!$payment->save()){
                return redirect()->route('payrollSheet.index')->with('error', 'Report not successfull!');
            }

            if ($request->get('format') != null and $request->get('format') == 'pdf') {
              //  $payment = 2000;
                $pdf = PDF::loadView('payrollSheet.perdiem_payment_pdf', compact(
                    'placedVolunteers',
                    'title',
                    'totals',
                    'scale',
                    'session',
                    'center',
                    'total_volunteers',
                    'sdate',
                    'edate',
                    'day'

                ))->setPaper('a4', 'landscape');

                return $pdf->download('perdiem_payment' . $year . 'pdf');
            }  else {

                return redirect()->route('payrollSheet.index')->with('message', 'Sorry currently We have no Ms exceel file');
            }

        }

        //////////////////////////////////////////////////////////////////////////
        elseif ($request->get('payment_type') == '3') { // for transport payment
            $placedVolunteers = Volunteer::whereRelation('status','acceptance_status', Constants:: VOLUNTEER_STATUS_CHECKEDIN)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->get();
            $total_volunteers = Volunteer::whereRelation('status','acceptance_status', Constants:: VOLUNTEER_STATUS_CHECKEDIN)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->count();

            $totals = [];
            $scale = [];
            $km = [];
            $tarif = TransportTarif::select('price')->get()->last()->price;

            foreach ($placedVolunteers as $key => $value) {

                array_push($totals, $this->calculate($value->woreda->zone->id, $value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->id));
                array_push($scale,$value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->scale);
                array_push($km,$this->getKm($value->woreda->zone->id,  $value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->id));
            }
               $total =0;
               foreach ($placedVolunteers as $placedVolunteer) {
               $total = $total+1;

               }
          ////////////////// insert record report table ////////////////////
               $payment= PaymentReport::create([
                'trainining_center_id' =>$center->id,
                'training_session_id' =>$traingSession->id,
                'payment_type_id'=>3,
                'user_id'=>Auth::user()->id,
                'status'=>1,
                'approved_by '=>null,
                'total_amount'=>0,
                'total_payee'=>$total
            ]);

            if(!$payment->save()){
                return redirect()->route('payrollSheet.index')->with('error', 'Report not successfull!');
            }
         ///////////////////////////////////////////////////////////////////////
            if ($request->get('format') != null and $request->get('format') == 'pdf') {
                $pdf = PDF::loadView('payrollSheet.transport_payment_pdf', compact(
                    'placedVolunteers',
                    'title',
                    'totals',
                    'scale',
                    'session',
                    'center',
                    'total_volunteers',
                    'sdate',
                    'edate',
                    'day',
                    'tarif',
                    'km'
                ))->setPaper('a4', 'landscape');

                return $pdf->download('transport_payment' . $year . 'pdf');
            } else {

                return redirect()->route('payrollSheet.index')->with('message', 'Sorry currently We have no Ms exceel file');
            }

           }

     //////////////////////////////////////////////////////////////////////////
        elseif ($request->get('payment_type') == '4') { // for Deployment payment

            $placedVolunteers = Volunteer::whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_DEPLOYED)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->get();
            $total_volunteers = Volunteer::whereRelation('status','acceptance_status',7)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('center'))->whereRelation('approvedApplicant', 'training_session_id', $request->get('session'))->count();
             $kms = [];
             $zones = [];
             $tarif = TransportTarif::select('price')->get()->last()->price;
            foreach ($placedVolunteers as $key => $value) {

                array_push($kms,$this->getKm(  $value->approvedApplicant->trainingPlacement->deployment->woreda->zone->id, $value->approvedApplicant->trainingPlacement->trainingCenterCapacity->trainingCenter->id
                ));

                if($kms==null) {

                   $kms = 0;
                }


               }
            $total =0;
            foreach ($placedVolunteers as $placedVolunteer) {
            $paid =  $kms * $tarif;

            }

            foreach ($placedVolunteers as $placedVolunteer) {
                $total = $total+1;

                }
             ////////////////// insert record report table ////////////////////
             $payment= PaymentReport::create([
                'trainining_center_id' =>$center->id,
                'training_session_id' =>$traingSession->id,
                'payment_type_id'=>4,
                'user_id'=>Auth::user()->id,
                'status'=>1,
                'approved_by '=>null,
                'total_amount'=>$paid, // It  should be checked
                'total_payee'=>$total
            ]);

            if(!$payment->save()){
                return redirect()->route('payrollSheet.index')->with('error', 'Report not successfull!');
            }

            if ($request->get('format') != null and $request->get('format') == 'pdf') {
                $pdf = PDF::loadView('payrollSheet.deployment_payment_pdf', compact(
                    'placedVolunteers',
                    'title',
                    'session',
                    'center',
                    'total_volunteers',
                    'sdate',
                    'edate',
                    'day',
                    'tarif',
                    'kms'
                ))->setPaper('A4', 'landscape');

                return $pdf->download('deployment_payment' . $year . 'pdf');
            } else {

                return redirect()->route('payrollSheet.index')->with('message', 'Sorry currently We have no Ms exceel file');
            }

           }
           //////////////////////////////////////////////////////////////////////////

     else {
            return redirect()->route('payrollSheet.index')->with('message', 'Sorry currently  no other typeo of paymment');
        }
    }

 public function payee($payroll_sheet_id) {

        $training_session_id    = PayrollSheet::select('training_session_id')->where('id', '=',$payroll_sheet_id)->get()->first()->training_session_id;
        $trainining_center_id   = PayrollSheet::select('trainining_center_id')->where('id', '=',$payroll_sheet_id)->get()->first()->trainining_center_id;
        $placedVolunteers       = $this->getPayee($training_session_id,$trainining_center_id);
        $center                 = TraininingCenter::where('id', $trainining_center_id)->get()->first();

        //  $PaymentType  = PaymentType::where('id', 1)->first(); // It should be checked the value of ID
        return view('payrollSheet.trainee_list', [
            'placedVolunteers' => $placedVolunteers,
          //  'PaymentType' => $PaymentType,
            'total_vol' =>   DB::table('volunteers')->count(),
            'payment_types' => PaymentType::all(),
            'center' => $center,
            'training_session_id'=>$training_session_id
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
   public function store(Payroll $payroll_id,Request $request) {
        $training_session_id = TrainingSession::availableSession()->first()->id;

     //  dd($training_session_id);

        if (PayrollSheet::where('training_session_id',$training_session_id )->where('trainining_center_id',$request->training_center)->count() > 0) {
            return redirect()->route('payrollSheet.index')->with('error', ' This payroll sheet alreardy exist!');
        }
        $payroll_sheet = new PayrollSheet();
        $payroll_sheet->payroll_id =$request->payroll_id;
        $payroll_sheet->trainining_center_id = $request->training_center;
        $payroll_sheet->training_session_id = TrainingSession::availableSession()->last()->id;
        $payroll_sheet->user_id = Auth::user()->id;
        $payroll_sheet->save();
        return redirect()->route('payrollSheet.index',['payroll_id'=>$payroll_id])->with('message', 'PayrollSheet created successfully');
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
            'PayrollSheet' => PayrollSheet::findOrFail($payrollsheet_id)
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
        return view('payrollsheet.edit', compact('payrollsheet'));
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
        $data = $request->validate(['name' => 'required|string|unique:payrollsheets,name,' . $payrollsheet->id]);
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
    public function destroy(Request $request, PayrollSheet $payrollsheet)
    {
        $payrollsheet->delete();
        if ($request->ajax()) {
            return response()->json(array('message' => 'deleted successfully'), 200);
        }
    }
}
