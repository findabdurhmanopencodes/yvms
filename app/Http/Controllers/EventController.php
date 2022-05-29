<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\EventImage;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('event.index',['events'=>Event::with('images')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'pictures.*' => 'required|image|mimes:jpg,jpeg,png',        ]);
        $event = new Event();
        $event->title = $request->title;
        $event->content = $request->content;
        $event->save();
        foreach ($request->file('pictures') as $imagefile) {
            $eventImage = new EventImage();
            $fileName = time() . '_' . $imagefile->getClientOriginalName();
            $filePath = $imagefile->storeAs('/events/'.'_'.$event->id, $fileName, 'public');
            $eventImage->url = $filePath;
            $eventImage->event_id = $event->id;
            $eventImage->save();
        }
        return redirect()->route('Events.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($event)
    {
        return view('event.show',['event'=>Event::find($event)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
    public function allEvents()
    {
        return view('event.all_events',['events'=>Event::latest()->paginate(3)]);
    }
    public function detailEvent($event)
    {
        return view('event\event_detail',['event'=>Event::find($event),'featuredEvents'=> Event::latest()->take(5)->get()]);
    }
}
