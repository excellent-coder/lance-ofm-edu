<?php

namespace App\Http\Controllers;

use App\Models\StudentExam;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year = '')
    {
        $exams = StudentExam::all();
        return view('admin.pages.students.exams.index', compact('exams', 'year'));
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
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function show(StudentExam $studentExam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentExam $studentExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentExam $studentExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentExam  $studentExam
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentExam $studentExam)
    {
        //
    }
}
