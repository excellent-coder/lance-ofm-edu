<?php

namespace App\Http\Controllers;

use App\Models\Licence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class LicenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $licences = Licence::orderBy('name', 'desc')->get();
        return view('admin.pages.licences.index', compact('licences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.licences.create');
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
                'name' => 'required|unique:licences,name',
                'fee' => 'required|numeric',
                'renewal' => 'required|numeric',
                'duration' => 'required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $l = new Licence();
        $l->name = $request->name;
        $slug = Str::slug($request->name);
        $l->slug = $slug;
        $l->fee = $request->fee;
        $l->duration = $request->duration;
        $l->renewal = $request->renewal;

        $l->active = $request->filled('active');

        $l->description = $request->description;
        $l->excerpt = $request->excerpt;

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $l->image = $file->storeAs('licences', $name);
            }
        }

        $l->save();

        return [
            'message' => 'Licence Added successfully',
            'status' => 200,
            'to' => route('admin.licences'),
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Licence  $licence
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $licence = Licence::where('slug', $slug)->firstOrFail();
        if (view()->exists("frontend.pages.licenses.$slug")) {
            return view("frontend.pages.licenses.$slug");
        }
        return $licence;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Licence  $licence
     * @return \Illuminate\Http\Response
     */
    public function edit(Licence $licence)
    {
        return view('admin.pages.licences.edit', compact('licence'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Licence  $licence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Licence $licence)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'name' => "required|unique:licences,name,$licence->id",
                'fee' => 'required|numeric',
                'renewal' => 'required|numeric',
                'duration' => 'required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $l = $licence;
        $l->name = $request->name;
        $slug = Str::slug($request->name);
        $l->slug = $slug;
        $l->fee = $request->fee;
        $l->duration = $request->duration;
        $l->renewal = $request->renewal;

        $l->active = $request->filled('active');

        $l->description = $request->description;
        $l->excerpt = $request->excerpt;

        if ($request->remove_image) {
            if (file_exists(public_path("storage/$l->image")) && $l->image) {
                unlink(public_path("storage/$l->image"));
            }
            $l->image = null;
        }


        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                if (file_exists(public_path("storage/$l->image")) && $l->image) {
                    unlink(public_path("storage/$l->image"));
                }

                $name = $slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $l->image = $file->storeAs('licences', $name);
            }
        }

        $l->save();

        return [
            'message' => 'Licence updated successfully',
            'status' => 200,
            'to' => route('admin.licences'),
            'type' => 'success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Licence  $licence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Licence::whereIn('id', $ids)->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Licence::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('Licence', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }

    public function members($slug)
    {
        $l = Licence::whereSlug($slug)->firstOrFail();
        $members = $l->members;
        $title = Str::upper($l->name) . ' LICENSED MEMBERS';
        return view('admin.pages.members.index', compact('members', 'title'));
    }
}
