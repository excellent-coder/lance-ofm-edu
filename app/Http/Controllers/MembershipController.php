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
            [
                'name' => 'required'
            ]
        );
        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        if (Membership::where('name', $request->name)
            ->where('parent_id', $request->parent)->first()
        ) {
            return [
                'message' => "This Membership $request->name already Exist",
                'errors' => 'Try another One'
            ];
        }

        $m = new Membership();
        $m->name = $request->name;
        $m->active = $request->filled('active');
        $m->slug = Str::slug("$request->name $request->parent");
        $m->parent_id = $request->parent;
        $m->application_fee = $request->application_fee;
        $m->induction_fee = $request->induction_fee;
        $m->annual_fee = $request->annual_fee;

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
    public function children(Request $request, Membership $parent)
    {
        if ($request->expectsJson()) {
            return $parent->children;
        }
        return redirect('/');
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
        $m->application_fee = $request->application_fee;
        $m->induction_fee = $request->induction_fee;
        $m->annual_fee = $request->annual_fee;

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

    public function members($slug)
    {
        $membership = Membership::whereSlug($slug)->firstOrFail();
        $members = $membership->members;
        $title = Str::upper($membership->name);
        return view('admin.pages.members.index', compact('members', 'title'));
    }
}
