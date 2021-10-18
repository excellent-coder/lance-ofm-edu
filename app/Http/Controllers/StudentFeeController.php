<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Program;
use App\Models\Session;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees = StudentFee::all();
        $sessions = Session::all();
        $programs = Program::all();
        $levels = Level::all();

        return view('admin.pages.students.fees.index', compact('fees', 'sessions', 'levels', 'programs'));
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
        $request->validate([
            'fee' => 'required',
            'amount' => 'required',
            'currency' => 'required'
        ]);

        // return $request->all();
        $sf = new StudentFee();
        $sf->session_id = $request->session;
        $sf->program_id = $request->program;
        $sf->level_id = $request->level;
        $sf->fee = $request->fee;
        $sf->currency = mb_strtoupper($request->currency, 'utf-8');
        $sf->amount = $request->amount;
        $sf->reason = $request->reason;

        $sf->save();
        return ['message' => 'student Fee added', 'status' => 200, 'type' => 'success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentFee  $studentFee
     * @return \Illuminate\Http\Response
     */
    public function show(StudentFee $studentFee)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentFee  $studentFee
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentFee $studentFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentFee  $studentFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentFee $fee)
    {
        $request->validate([
            'fee' => 'required',
            'amount' => 'required',
            'currency' => 'required'
        ]);

        // return $request->all();
        $fee->session_id = $request->session;
        $fee->program_id = $request->program;
        $fee->level_id = $request->level;
        $fee->fee = $request->fee;
        $fee->currency = mb_strtoupper($request->currency, 'utf-8');
        $fee->amount = $request->amount;
        $fee->reason = $request->reason;

        $fee->save();
        return ['message' => 'student Fee updated', 'status' => 200, 'type' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentFee  $studentFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentFee $studentFee)
    {
        //
    }
}
