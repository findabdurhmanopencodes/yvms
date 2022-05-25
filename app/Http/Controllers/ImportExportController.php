<?php

namespace App\Http\Controllers;

use App\Exports\VolunteerExport;
use App\Imports\VolunteerImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    //
    public function importView(Request $request)
    {
        return view('importFile');
    }

    public function importVolunteers(Request $request)
    {
        Excel::import(new VolunteerImport, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportVolunteers(Request $request)
    {
        $users = DB::table('volunteers')->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->where('training_center_capacities.trainining_center_id', 1)->select('id_number', 'first_name', 'phone', 'gender')->get();
        return Excel::download(new VolunteerExport($users, ['Id Number', 'Name', 'phone', 'gender', 'Bank Account Number']), 'volunteers_Bank.xlsx');
    }
}
