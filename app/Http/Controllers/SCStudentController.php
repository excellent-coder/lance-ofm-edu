<?php

namespace App\Http\Controllers;

use App\Models\SCStudent;
use Illuminate\Http\Request;

class SCStudentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function show(SCStudent $sCStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(SCStudent $sCStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCStudent $sCStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(SCStudent $sCStudent)
    {
        //
    }


    public function portal()
    {
        // return auth('scs')->user()->programs;
        return view('frontend.scs.index');
    }
}
