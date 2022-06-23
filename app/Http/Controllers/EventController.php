<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('event.index', ['events' => Event::with('images')->paginate(10)]);
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
            'pictures.*' => 'required|image|mimes:jpg,jpeg,png',
        ]);
        $event = new Event();
        $event->title = $request->title;
        $event->content = $request->content;
        $event->save();
        foreach ($request->file('pictures') as $imagefile) {
            $eventImage = new EventImage();
            $fileName = time() . '_' . $imagefile->getClientOriginalName();
            $filePath = $imagefile->storeAs('/events/' . '_' . $event->id, $fileName, 'public');
            $eventImage->url = '/storage/' .    $filePath;
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
        return view('event.show', ['event' => Event::find($event)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($event)
    {
        //
        // dd($event);
        return view('event.edit', ['event' => Event::find($event)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event)
    {
        $event = Event::with('images')->where('id', $event)->first();
        if ($request->has('pictures')) {
            foreach ($request->file('pictures') as $imagefile) {
                // if(file_exists(public_path($image->url))){
                // unlink($image ->photos);
                // dump($image);
                $eventImage = new EventImage();
                $fileName = time() . '_' . $imagefile->getClientOriginalName();
                $filePath = $imagefile->storeAs('/events/' . '_' . $event->id, $fileName, 'public');
                $eventImage->url = '/storage/' .    $filePath;
                $eventImage->event_id = $event->id;
                $eventImage->save();

                // }
            }
        }
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:3',
            'featured_image' => 'sometimes|max:2000',

        ]);
        $url = '';
        $event->update($data);
        return redirect(route('Events.index'))->with('message', 'Event updated successfully');
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
        return view('event.all_events', ['events' => Event::latest()->paginate(3)]);
    }
    public function detailEvent($event)
    {
        return view('event\event_detail', ['event' => Event::find($event), 'featuredEvents' => Event::latest()->take(5)->get()]);
    }
    public function removeImage($eventImage)
    {
        $image = EventImage::find($eventImage);
        if (file_exists(public_path($image->url))) {
            unlink(public_path($image->url));
            $image->delete();
        }
        return redirect()->back();
    }
}
