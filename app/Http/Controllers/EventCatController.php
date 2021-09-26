<?php

namespace App\Http\Controllers;

use App\Models\EventCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = EventCat::all();
        return view('admin.pages.events.categories', compact('categories'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:event_cats,name',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $e = new EventCat();
        $e->name = $request->name;
        $e->slug = Str::slug($request->name);
        $e->save();
        return [
            'message' => 'Event Category Added successfully',
            'status' => 200,
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventCat  $eventCat
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // return $slug;
        $cat = EventCat::whereSlug($slug)->firstOrFail();
        return view('frontend.events.category', compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventCat  $eventCat
     * @return \Illuminate\Http\Response
     */
    public function edit(EventCat $eventCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventCat  $eventCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventCat $cat)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'name' => "required|unique:event_cats,name,$cat->id",
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $e = $cat;
        $e->name = $request->name;
        $e->slug = Str::slug($request->name);
        $e->save();
        return [
            'message' => 'Event Category updated successfully',
            'status' => 200,
            'type' => 'success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventCat  $eventCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total =  EventCat::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('Category', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
