<?php

namespace App\Http\Controllers;

use App\Models\MemberAppeal;
use App\Models\MemberRequest;
use Illuminate\Http\Request;

class MemberAppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(MemberRequest $member)
    {
        return $member;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MemberRequest $member)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberAppeal  $memberAppeal
     * @return \Illuminate\Http\Response
     */
    public function show(MemberAppeal $memberAppeal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberAppeal  $memberAppeal
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberAppeal $memberAppeal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberAppeal  $memberAppeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberAppeal $memberAppeal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberAppeal  $memberAppeal
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberAppeal $memberAppeal)
    {
        //
    }
}
