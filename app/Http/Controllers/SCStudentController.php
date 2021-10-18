<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\SCStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\ScsPayment;
use App\Models\ScsProgram;

class SCStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = SCStudent::all();
        // return $students;
        return view('admin.pages.scs.index', compact('students'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function show(SCStudent $student)
    {
        $last = SCStudent::latest('id')->first();
        if ($last) {
            $last_matric = $last->matric_no;
        }
        // return $student->allPrograms;
        return view('admin.pages.scs.show', compact('student', 'last_matric'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCStudent $student)
    {
        $valid = Validator::make(
            $request->all(),
            ['matric_no' => 'required_if:approved,1']
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $student->active = $request->filled('active');
        if (!$student->approved_at) {
            if ($request->filled('approved')) {
                $student->approved_at = date('Y-m-d H:i:s');
                $student->matric_no = $request->matric_no;
            }
        }

        $student->save();
        return [
            'message' => 'student updated successfully',
            'type' => 'success',
            'status' => 200,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SCStudent  $sCStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $files = SCStudent::whereIn('id', $ids)->get(['passport', 'certificate']);

        $files->each(function ($file) {
            $p = $file->passport;
            $c = $file->certificate;
            if (file_exists(public_path("storage/$file->passport")) && $p) {
                unlink(public_path("storage/$file->passport"));
            }
            if (file_exists(public_path("storage/$file->certificate")) && $c) {
                unlink(public_path("storage/$file->certificate"));
            }
        });

        $total =  SCStudent::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('students', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }


    public function portal()
    {
        // return auth('scs')->user()->programs;
        return view('frontend.scs.index');
    }

    public function applyProgram()
    {
        $userPrograms = ScsProgram::where('scs_id', auth('scs')->id())
            ->where('payment_id', '!=', null)
            ->pluck('program_id');
        // return $userPrograms;
        $scPrograms = Program::where('active', 1)
            ->where('is_program', 1)
            ->where('visibility', '!=', 2)
            ->whereNotIn('id', $userPrograms)
            ->get();
        // return $scPrograms;
        return view('frontend.scs.programs.register', compact('scPrograms'));
    }

    public function updateProgram(Request $request)
    {
        // return ['message' => 'Work in progress'];
        $request->validate(
            [
                'program' => 'required',
                'program.required' => 'Please choose a program'
            ]
        );

        $p = $request->program;
        if (ScsProgram::where('scs_id', auth('scs')->id())
            ->whereProgramId($p)->first()
        ) {
            return ['message' => 'You already applied for this program', 'status' => 200, 'type' => 'sucess'];
        }

        $s = new ScsProgram();
        $s->program_id = $p;
        $s->s_c_student_id = auth('scs')->id();
        $s->save();

        return [
            'message' => "You have successfuly registered for the progroams",
            'desc' => ' Login often to check if they have been approved so you can take your lessons',
            'status' => 200,
            'type' => 'success',
            'to' => route('scs')
        ];
    }


    public function program($slug)
    {
        $program = Program::where('slug', $slug)->firstOrFail();
        return view('frontend.scs.programs.courses', compact('program'));
    }

    public function course($course)
    {
        $course = Course::where('slug', $course)->firstOrFail();
        return view('frontend.scs.programs.lessons', compact('course'));
    }

    public function lesson($lesson)
    {
        $lesson = Lesson::where('slug', $lesson)->firstOrFail();
        // return $lesson->load('materials');
        return view('frontend.scs.programs.study', compact('lesson'));
    }
}
