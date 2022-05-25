<?php

namespace App\Http\Controllers;

use App\Exports\VolunteerExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    //
    public function importView(Request $request){
        return view('importFile');
    }

    public function import(Request $request){
        Excel::import(new ImportUser, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportVolunteers(Request $request){

        return Excel::download(new VolunteerExport(DB::table('volunteers')->select('id_number','first_name')->get(),['Id Number', 'First Name','Bank Account Number']), 'volunteers_Bank.xlsx');
    }
}
