<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Application;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Lesson;
use App\Mail\AdminApplied;
use App\Mail\Applied;
use App\Mail\StudentVerifyEmail;
use App\Models\Program;
use App\Models\StudentRequest;
use Illuminate\Support\Facades\Mail;
use stdClass;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest('id')->take(100)->get();
        // return $students;
        return view('admin.pages.students.index', compact('students'));
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

    public function addPassword(Student $student)
    {
        if ($student->password) {
            return view('errors.404');
        }
        return view('auth.pgs.add-password', compact('student'));
    }

    public function storePassword(Request $request, Student $student)
    {
        if ($student->password) {
            return [
                'status' => 200,
                'type' => 'error',
                'message' => 'something went wrong',
                'to' => '/student'
            ];
        }
        $student->password = bcrypt($request->password);
        $student->save();
        auth('pgs')->login($student);
        return [
            'message' => 'Redirecting to dashboard',
            'to' => route('pgs'),
            'status' => 200,
            'type' => 'success'
        ];
    }

    public function dashboard()
    {
        // return auth('pgs')->user(); //->program;
        return view('frontend.pgs.index');
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    public function docs(Student $student)
    {
        $appDocs = $student->appRequest()
            ->first(['documents', 'passport', 'certificates']);
        // return $appDocs;
        return $student;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        // $files = Student::whereIn('id', $ids)->get(['passport', 'certificate', 'documents']);

        // $files->each(function ($file) {
        //     if (file_exists(public_path("storage/$file->image")) && $file->image) {
        //         unlink(public_path("storage/$file->image"));
        //     }
        //     if (file_exists(public_path("storage/$file->image")) && $file->image) {
        //         unlink(public_path("storage/$file->image"));
        //     }
        // });

        $total =  Student::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('student', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }

    public function course($slug)
    {
        $course = Course::where('slug', $slug)->where('visibility', '!=', '3')
            ->firstOrFail();
        return view('frontend.pgs.lessons.show', compact('course'));
    }

    public function lesson($slug)
    {
        $lesson = Lesson::where('slug', $slug)->where('visibility', '!=', '3')
            ->firstOrFail();
        return view('frontend.pgs.lessons.study', compact('lesson'));
    }
}
