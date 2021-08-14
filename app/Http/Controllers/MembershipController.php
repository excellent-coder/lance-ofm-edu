<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberships = Membership::all();
        return view('admin.pages.memberships.index', compact('memberships'));
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
            ['name' => 'required']
        );
        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $m = new Membership();
        $m->name = $request->name;
        $m->active = $request->filled('active');
        $slug = Str::slug($request->name);
        $m->slug = $slug;

        // add application form
        if ($request->hasFile('form')) {
            $file = $request->file('form');
            if ($file->isValid()) {

                $name = "ISAM-" . Str::upper($slug) . "-MEMBERSHIP-APPLICATION-FORM"
                    . '.' . $file->getClientOriginalExtension();
                $m->form = $file->storeAs('membership-forms', $name);
            }
        }

        $m->save();

        return [
            'message' => "New Membership added successfully",
            'status' => 200,
            'timeout' => 10000,
            'type' => 'success',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $membership)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            ['name' => 'required']
        );
        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $m = $membership;
        $m->name = $request->name;
        $m->active = $request->filled('active');
        $slug = Str::slug($request->name);

        // add application form
        if ($request->hasFile('form')) {
            $file = $request->file('form');
            if ($file->isValid()) {

                $name = "ISAM-" . Str::upper($slug) . "-MEMBERSHIP-APPLICATION-FORM"
                    . '.' . $file->getClientOriginalExtension();
                $m->form = $file->storeAs('membership-forms', $name);
            }
        }

        $m->save();

        return [
            'message' => "$m->name Membership updated successfully",
            'status' => 200,
            'timeout' => 5000,
            'desc' => 'Reload page to see changes',
            'type' => 'success',
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
