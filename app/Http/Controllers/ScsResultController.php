<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use App\Models\Scs;
use App\Models\ScsProgram;
use App\Models\ScsResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScsResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year = '')
    {
        if (!$year) {
            $year = date('Y');
        }
        $results = ScsResult::whereRaw("year(`created_at`) = '$year'")->get();
        // return $results[0];
        return view('admin.pages.scs.results.index', compact('results', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = Scs::selectRaw('DISTINCT(year(`created_at`)) as year ')->pluck('year'); //->get();

        // return $years;
        return view('admin.pages.scs.results.create', compact('years'));
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
        $request->validate([
            'year' => 'required',
            'program' => 'required',
            'course' => 'required',
            'student' => 'required',
            'score' => 'required|numeric',
            'exam_date' => 'nullable',
        ]);

        $saved = ScsResult::where('scs_id', $request->student)->where('program_id', $request->program)
            ->where('course_id', $request->course)->first();

        if ($saved) {
            return [
                'message' => 'You have already added score for this usre',
                'type' => 'warning', 'status' => 200, 'timeout' => 0
            ];
        }

        $sr = new ScsResult();
        $sr->scs_id = $request->student;
        $sr->program_id = $request->program;
        $sr->course_id = $request->course;
        $sr->score = $request->score;
        $sr->exam_date = $request->exam_date;

        $sr->save();

        return ['message' => 'result added', 'status' => 200, 'type' => 'success', 'timeout' => 2500];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScsResult  $scsResult
     * @return \Illuminate\Http\Response
     */
    public function show(ScsResult $scsResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScsResult  $scsResult
     * @return \Illuminate\Http\Response
     */
    public function edit(ScsResult $scsResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScsResult  $scsResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScsResult $scsResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScsResult  $scsResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScsResult $scsResult)
    {
        //
    }

    public function scs()
    {
        $results = auth('scs')->user()->results;
        // return $results;
        $ids = ScsResult::where('scs_id', auth('scs')->id())->pluck('program_id');
        // return $scsPrograms;
        $scsPrograms = Program::find($ids, ['title', 'abbr', 'id', 'slug']);

        // return $scsPrograms;
        return view('frontend.scs.result', compact('scsPrograms'));
    }

    public function json(Request $request)
    {
        if (!$request->year && !$request->program) {
            return;
        }

        $year = $request->year;
        $program = $request->program;
        if (!empty($program)) {
            // $scs = DB::select("select distinct(scs_id) from scs_programs where program_id = '$program'");
            $scs = ScsProgram::selectRaw("distinct(`scs_id`)")->where('program_id', $program)
                // ->get();
                // ->toSql();
                ->pluck('scs_id');
            // return $scs;
            $scs = Scs::find($scs, ['id', 'first_name', 'last_name']);
            $courses = Course::where('program_id', $program)->get();
            return [
                'scs' => $scs,
                'courses' => $courses
            ];
        }

        $ps = ScsProgram::selectRaw("DISTINCT(program_id)")->whereRaw("YEAR(`created_at`) = '$year'")->pluck('program_id');
        $programs = Program::find($ps, ['id', 'title', 'abbr']);
        return $programs;
    }
}
