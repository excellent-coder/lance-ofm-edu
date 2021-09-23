<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        $levels = Level::latest('level')->get();
        $programs = Program::all();
        // return $courses;
        return view('admin.pages.courses.index', compact(
            'courses',
            'levels',
            'programs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::latest('level')->get();
        $programs = Program::all();
        return view('admin.pages.courses.create', compact('programs', 'levels'));
    }

    public function pl($program, $level)
    {
        $courses = Course::where('program_id', $program)->where('level_id', $level)->get();
        return $courses;
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
                'name' => 'required|max:150',
                'code' => 'required|max:100',
                'program_id' => 'required',
                'visibility' => 'required',
                'level_id' => 'required'
            ],
            [
                'program_id.required' => 'Please choose program that this course belongs to',
                'level_id.required' => 'Please choose the level that this course belongs to',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $slug = Str::slug($request->code);

        $course = new Course();

        $course->slug = $slug;
        $course->name = $request->name;
        $course->code = $request->code;

        $course->program_id = $request->program_id;
        $course->level_id = $request->level_id;

        $course->description = $request->description;
        $course->visibility = $request->visibility;

        $course->excerpt = $request->excerpt;
        $course->active = intval($request->active);

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $slug . "-" . time()
                    . '.' . $file->extension();
                $course->image = $file->storeAs('courses', $name);
            }
        }

        $course->save();
        $to = $request->modal ? false : route('admin.courses');
        return [
            'message' => "Course created successfully",
            'status' => 200,
            'type' => 'success',
            'to' => $to
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        // return $course;
        if (view()->exists("frontend.courses.static.$slug")) {
            return view("frontend.courses.static.$slug", compact('course'));
        }
        return view('frontend.courses.single', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $levels = Level::latest('level')->get();
        $programs = Program::all();
        return view('admin.pages.courses.edit', compact('course', 'levels', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'name' => "required|unique:courses,name,$course->id|max:150",
                'code' => "required|unique:courses,code,$course->id|max:100",
                'image' => 'nullable|file|image',
                'program_id' => 'required',
                'visibility' => 'required',
                'level_id' => 'required'
            ],
            // [
            //     'name.unique' => 'This course is already taken',
            //     'code.unique' => 'This course code is already taken'
            // ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $course->name = $request->name;
        $course->code = $request->code;
        $slug = Str::slug($request->code);
        $course->description = $request->description;

        $course->excerpt = $request->excerpt;

        $course->program_id = $request->program_id;
        $course->level_id = $request->level_id;

        $course->visibility = $request->visibility;

        $course->active = intval($request->active);

        if ($request->remove_image) {
            if (file_exists(public_path("storage/$course->image")) && $course->image) {
                unlink(public_path("storage/$course->image"));
            }
            $course->image = null;
        }

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                if (file_exists(public_path("storage/$course->image")) && $course->image) {
                    unlink(public_path("storage/$course->image"));
                }

                $name = $slug . "-" . time()
                    . '.' . $file->extension();
                $course->image = $file->storeAs('courses', $name);
            }
        }

        $course->save();

        // return $course;

        return [
            'message' => "$course->code updated successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.courses')
        ];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Course::whereIn('id', $ids)->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Course::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('Course', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
