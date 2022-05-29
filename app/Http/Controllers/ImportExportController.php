<?php

namespace App\Http\Controllers;

use App\Exports\VolunteerExport;
use App\Imports\VolunteerImport;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    //
    public function importView(Request $request)
    {
        return view('import_export_volunteer\view');
    }

    public function importVolunteers(Request $request)
    {
        Excel::import(new VolunteerImport, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportVolunteers(Request $request)
    {
        //need improvemt

        $users = DB::table('volunteers')->leftJoin('statuses', 'volunteers.id', '=', 'statuses.volunteer_id')->where('acceptance_status','=',5)->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->where('training_center_capacities.trainining_center_id', $request->route('training_center'))->select('id_number', 'first_name', 'phone', 'gender','account_number')->get();
        return Excel::download(new VolunteerExport($users, ['Id Number', 'Name', 'phone', 'gender', 'Bank Account Number']), ' '.TraininingCenter::find($request->route('training_center'))->code.'_volunteers_Bank_account.xlsx');
    }
}
