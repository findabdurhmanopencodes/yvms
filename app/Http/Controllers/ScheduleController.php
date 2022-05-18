<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Training;
use App\Models\TrainingSchedule;
use App\Models\TrainingSession;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TrainingSession $trainingSession)
    {
        $trainingSchedules = $trainingSession->trainingScheduless;
        $events = [];
        foreach ($trainingSchedules as $trainingSchedule) {
            $now = Carbon::now();
            $className = ($now >= $trainingSchedule->schedule->date) ? 'fc-event-light fc-event-solid-danger' : 'fc-event-light fc-event-solid-primary';
            $start = $trainingSchedule->schedule->date;
            $shift = $trainingSchedule->schedule->shift;
            if($shift ==0 ){
                $start = Carbon::createFromDate($start)->setHour(2);
            }else{
                $start = Carbon::createFromDate($start)->setHour(8);
            }
            $event = [
                'url' => $trainingSchedule->id,
                'title' => $trainingSchedule->training->name.$trainingSchedule->id,
                'start' => $start->format('Y-m-d H:i:s'),
                'description' => $trainingSchedule->training?->description,
                'className' => $className,
            ];
            array_push($events, $event);
        }
        $trainings = Training::all();
        return view('schedule.index', compact('trainingSession', 'trainings', 'trainingSchedules', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession,Schedule $schedule)
    {
        dd($trainingSession);
    }

    public function addSchedule(Request $request, TrainingSession $trainingSession)
    {
        $request->validate([
            'schedule_start_date' => ['required'],
            'schedule_end_date' => ['required'],
            'training' => ['required'],
            'shift' => ['required', 'in:0,1,2']
        ]);
        $startDateEt = $request->get('schedule_start_date');
        $endDateEt = $request->get('schedule_end_date');
        $date =  DateTime::createFromFormat('d/m/Y', $startDateEt);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $startDateGC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $date =  DateTime::createFromFormat('d/m/Y', $endDateEt);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $endDateGC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $trainingStartDate = $trainingSession->training_start_date;
        $trainingEndDate = $trainingSession->training_end_date;
        $now = Carbon::now();
        if (Carbon::createFromDate($startDateGC)->isAfter(Carbon::createFromDate($endDateGC))) {
            $validationException = ValidationException::withMessages([
                'schedule_start_date' => 'Schedule start date must be before schedule end date',
            ]);
            throw $validationException;
        }
        if (Carbon::createFromDate($startDateGC)->isBefore($now)) {
            $errorEt = DateTimeFactory::fromDateTime($now)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'schedule_start_date' => 'Schedule Start date must be a date after ' . $errorEt,
            ]);
            throw $validationException;
        }
        if (!Carbon::createFromDate($startDateGC)->isBetween($trainingStartDate, $trainingEndDate)) {
            $afterET = DateTimeFactory::fromDateTime($trainingStartDate)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($trainingEndDate)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'schedule_start_date' => 'The schedule start date must be a date between ' . $afterET . ' and ' . $beforeET,
            ]);
            throw $validationException;
        }
        if (!Carbon::createFromDate($endDateGC)->isBetween($trainingStartDate, $trainingEndDate)) {
            $afterET = DateTimeFactory::fromDateTime($trainingStartDate)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($trainingEndDate)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'schedule_end_date' => 'The schedule end date must be a date between ' . $afterET . ' and ' . $beforeET,
            ]);
            throw $validationException;
        }
        $shift = $request->get('shift');
        try {
            $training = Training::findOrFail($request->get('training'));
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['training' => 'Please select correct training']);
        }
        for ($i = $startDateGC; $i <= $endDateGC; $i->modify('+1 day')) {
            $schedule = Schedule::where('training_session_id', '=', $trainingSession->id)->where('date', '=', $i)->where('shift', '=', $shift)->first();
            if ($schedule == null) {
                if ($shift != 2) {
                    $schedule = Schedule::create([
                        'training_session_id' => $trainingSession->id,
                        'date' => $i,
                        'shift' => $shift,
                    ]);
                } else {
                    $schedule = Schedule::create([
                        'training_session_id' => $trainingSession->id,
                        'date' => $i,
                        'shift' => 0,
                    ]);
                    $schedule = Schedule::create([
                        'training_session_id' => $trainingSession->id,
                        'date' => $i,
                        'shift' => 1,
                    ]);
                }
            }
            $trainingSchedule = TrainingSchedule::where('training_id', '=', $training->id)->where('schedule_id', '=', $schedule->id)->first();
            if ($trainingSchedule == null) {
                TrainingSchedule::create([
                    'training_id' => $training->id,
                    'schedule_id' => $schedule->id,
                ]);
            }
        }
        return redirect()->back()->with('message', 'Schedule created successfully');
    }
}
