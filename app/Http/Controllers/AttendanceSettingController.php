<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceSettingRequest;
use App\Http\Requests\UpdateAttendanceSettingRequest;
use App\Models\AttendanceSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AttendanceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        // $this->authorizeResource(AttendanceSetting::class,'AttendanceSetting');

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(AttendanceSetting::select())->make(true);
        }
       $attendanceSettings =AttendanceSetting::orderBy('id', 'desc')->Paginate(10);

        return view('attendanceSetting.index', compact('attendanceSettings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

          return view('attendanceSetting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransportTarifRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceSettingRequest $request)
    {
        //$request->validate(['name' => 'required|string|unique:payment_types,name']);
        $request->validate(['days' => 'required|numeric|max:30:min:0:attendance_setting,days']);

        AttendanceSetting::create([

            'days' => $request->get('days'),
          //  'km'=>$request->get('km')
        ]);

      return redirect()->route('attendanceSetting.index')->with('message', ' attendanceSetting  created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceSetting $attendanceSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceSetting $attendanceSetting)
    {
        return view('attendanceSetting.edit', compact('attendanceSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransportTarifRequest  $request
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceSettingRequest $request, AttendanceSetting $attendanceSetting)

    {
        $attendanceSetting->days = $request->get('days');
        $data =  $request->validate(['days' => 'required|numeric|max:30:min:0:attendance_settings,days']);
        $attendanceSetting->save($data);

        return redirect()->route('attendanceSetting.index')->with('message', 'attendanceSetting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransportTarif  $transportTarif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,AttendanceSetting $attendanceSetting)
    {
        $attendanceSetting->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
