<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Level;
use App\Models\Program;
use App\Models\Session;
use App\Models\StudentActive;

class StudentResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->year;
        if (!$year) {
            $year = date('Y');
        }
        $results = StudentResult::whereRaw("year(`created_at`) = '$year'")->get();
        // return $results;
        return view('admin.pages.students.results.index', compact('results', 'year'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $years = Student::selectRaw('DISTINCT(year(`created_at`)) as year ')->pluck('year'); //->get();
        $sessions = Session::all(['id', 'name']);
        $programs = Program::where('visibility', '!=', '3')->get(['id', 'abbr', 'title']);
        $levels = Level::all(['id', 'name']);
        return view('admin.pages.students.results.create', compact('sessions', 'programs', 'levels'));
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
            'session' => 'required',
            'program' => 'required',
            'level' => 'required',
            'course' => 'required',
            'score' => 'required'
        ]);
        // return $request->all();
        $sr = new StudentResult();
        $sr->student_id = $request->student;
        $sr->program_id = $request->program;
        $sr->session_id = $request->session;
        $sr->level_id = $request->level;
        $sr->course_id = $request->course;
        $sr->score = $request->score;
        $sr->exam_date = $request->exam_date;
        $sr->retaken = $request->filled('retaken');

        $sr->save();
        return ['message' => 'result added', 'status' => 200, 'type' => 'success', 'timeout' => 2500];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentResult  $studentResult
     * @return \Illuminate\Http\Response
     */
    public function show(StudentResult $studentResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentResult  $studentResult
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentResult $result)
    {
        $sessions = Session::all(['id', 'name']);
        $programs = Program::where('visibility', '!=', '3')->get(['id', 'abbr', 'title']);
        $levels = Level::all(['id', 'name']);
        $courses = Course::where('program_id', $result->program_id)
            ->where('visibility', '!=', '3')
            ->get(['id', 'name', 'code']);

        $ids = StudentActive::selectRaw("DISTINCT(`student_id`) as sid")
            ->where('program_id', $result->program_id)
            ->where('session_id', $result->session_id)
            ->where('level_id', $result->level_id)
            ->pluck('sid');

        // return $ids;

        // get all students
        $students = Student::find($ids, ['id', 'name']);


        return view(
            'admin.pages.students.results.edit',
            compact('sessions', 'programs', 'levels', 'courses', 'students', 'result')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentResult  $studentResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentResult $result)
    {
        $request->validate([
            'session' => 'required',
            'program' => 'required',
            'level' => 'required',
            'course' => 'required',
            'score' => 'required'
        ]);
        // return $request->all();
        $result->student_id = $request->student;
        $result->program_id = $request->program;
        $result->session_id = $request->session;
        $result->level_id = $request->level;
        $result->course_id = $request->course;
        $result->score = $request->score;
        $result->exam_date = $request->exam_date;
        $result->retaken = $request->filled('retaken');

        $result->save();
        return ['message' => 'result updated', 'status' => 200, 'type' => 'success', 'timeout' => 2500];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentResult  $studentResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentResult $studentResult)
    {
        //
    }

    public function pgs()
    {
        $results = auth('pgs')->user()->results;
        // return $results;
        $user = auth('pgs')->user();
        $ids = StudentResult::selectRaw("DISTINCT(`level_id`) as lid")->where('student_id', $user->id)->pluck('lid');
        // return $ids;
        $levels = Level::find($ids);

        // return $levels;
        return view('frontend.pgs.exam.result', compact('levels'));
    }

    public function json(Request $request)
    {
        $request->validate(['program' => 'required', 'session' => 'required', 'level' => 'required']);

        $session = $request->session;
        $program = $request->program;
        $level = $request->level;

        $ids = StudentActive::selectRaw("DISTINCT(`student_id`) as sid")
            ->where('program_id', $program)
            ->where('session_id', $session)
            ->where('level_id', $level)
            ->pluck('sid');

        // return $ids;

        // get all students
        $students = Student::find($ids, ['id', 'name']);

        // get all courses
        $courses = Course::where('program_id', $program)->where('visibility', '!=', '3')->get(['id', 'name', 'code']);

        return [
            'students' => $students,
            'courses' => $courses
        ];
    }
}
