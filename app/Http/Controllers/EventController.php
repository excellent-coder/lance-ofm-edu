<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('start_at')->get();
        return view('admin.pages.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = EventCat::all();
        return view('admin.pages.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'category' => 'required',
                'price' => 'nullable|numeric',
                'start_at' => 'required',
                'end_at' => 'required',
                'image' => 'required|file|image'

            ],
            ['image.required' => 'Preview Phot is required']
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $e = new Event();

        $title = $request->title;
        $slug = Str::limit(Str::slug($title), 180, '');

        if (Event::where('slug', $slug)->first()) {
            $slug .= '-' . Event::where('slug', 'like', "%$slug%")->count();
        }

        $e->title = $title;
        $e->slug = $slug;
        $e->start_at = $request->start_at;
        $e->end_at = $request->end_at;
        $e->description = $request->description;
        $e->event_cat_id = $request->category;
        $e->price = $request->price;

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $e->image = $file->storeAs('licences', $name);
            }
        }

        $e->save();

        return [
            'message' => 'Event Added successfully',
            'status' => 200,
            'to' => route('admin.events'),
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->whereActive('1')
            ->where('end_at', '>', date('Y-m-d H:i:s'))
            ->firstOrFail();
        // events that jave not strted
        $events = Event::where('end_at', '>', date('Y-m-d H:i:s'))->get();
        // return $events;
        return view('frontend.events.single', compact('event', 'events'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $categories = EventCat::all();
        return view('admin.pages.events.edit', compact('categories', 'event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'category' => 'required',
                'price' => 'nullable|numeric',
                'start_at' => 'required',
                'end_at' => 'required',
                'image' => 'nullable|file|image'

            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $e = $event;

        $title = $request->title;

        $e->title = $title;
        $e->start_at = $request->start_at;
        $e->end_at = $request->end_at;
        $e->description = $request->description;
        $e->event_cat_id = $request->category;
        $e->price = $request->price;

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $e->slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $e->image = $file->storeAs('Events', $name);
            }
        }

        $e->save();

        return [
            'message' => 'Event updated successfully',
            'status' => 200,
            'to' => route('admin.events'),
            'type' => 'success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Event::whereIn('id', $ids)->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Event::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('Event', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }

    public function register($slug)
    {
        $event = Event::whereSlug($slug)->firstOrFail();
        return view('frontend.events.register', compact('event'));
    }
    public function events()
    {
        $events = Event::where('end_at', '>', date('Y-m-d H:i:s'))
            ->orderBy('start_at', 'ASC')
            ->get();
        return view('frontend.events.index', compact('events'));
    }
}
