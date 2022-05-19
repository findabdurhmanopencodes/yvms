<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\TrainingMaster;
use App\Http\Requests\StoreTrainingMasterRequest;
use App\Http\Requests\UpdateTrainingMasterRequest;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class TrainingMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = TrainingMaster::paginate(10);
        return view('master.index', compact('masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $master = null;
        $trainingCenters = TraininingCenter::all();
        return view('master.create', compact('trainingCenters', 'master'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingMasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingMasterRequest $request)
    {
        $data = $request->validated();
        $userData = $data;
        $date = DateTime::createFromFormat('d/m/Y', $request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = new Carbon();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $after = Carbon::now()->subYears(100);
        $before = $date->subYears(18);
        if (!Carbon::createFromDate($dob_GC)->isBetween($after, $before)) {
            $afterET = DateTimeFactory::fromDateTime($after)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($before)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'dob' => 'The Date of Birth must be a date after ' . $afterET . ' before ' . $beforeET,
            ]);
            throw $validationException;
        }
        unset($userData['bank_account']);
        $userData['password'] = Str::random(8);
        $userData['dob'] = $dob_GC;
        $userData['password'] = Hash::make($userData['password']);
        $user = User::create($userData);
        TrainingMaster::create([
            'user_id' => $user->id,
            'bank_account' => $data['bank_account'],
        ]);
        event(new Registered($user));
        return redirect()->route('training_master.index')->with('message','Training master registered successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingMaster  $trainingMaster
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingMaster $trainingMaster)
    {
        return view('master.show',compact('trainingMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingMaster  $trainingMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingMaster $trainingMaster)
    {
        $master = $trainingMaster;
        $trainingCenters = TraininingCenter::all();
        return view('master.create',compact('master','trainingCenters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingMasterRequest  $request
     * @param  \App\Models\TrainingMaster  $trainingMaster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingMasterRequest $request, TrainingMaster $trainingMaster)
    {
        $data = $request->validated();
        $userData = $data;
        $date = DateTime::createFromFormat('d/m/Y', $request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = new Carbon();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $after = Carbon::now()->subYears(100);
        $before = $date->subYears(18);
        if (!Carbon::createFromDate($dob_GC)->isBetween($after, $before)) {
            $afterET = DateTimeFactory::fromDateTime($after)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($before)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'dob' => 'The Date of Birth must be a date after ' . $afterET . ' before ' . $beforeET,
            ]);
            throw $validationException;
        }
        unset($userData['bank_account']);
        $userData['password'] = Str::random(8);
        $userData['dob'] = $dob_GC;
        $userData['password'] = Hash::make($userData['password']);
        $user = $trainingMaster->user;
        $user->update($userData);
        $trainingMaster->update([
            'bank_account' => $data['bank_account']
        ]);
        $user->save();
        $trainingMaster->save();
        return redirect()->back()->with('message','Training master information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingMaster  $trainingMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingMaster $trainingMaster)
    {
        $trainingMaster->delete();
        return redirect()->back()->with('message','Training master deleted successfully');
    }
}
