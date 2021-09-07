<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Level;
use App\Models\Program;
use App\Models\Course;
use App\Models\Material;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cardLinks = [];
        $lessons = Lesson::all();

        // return $lessons;
        return view(
            'admin.pages.lessons.index',
            compact(
                'cardLinks',
                'lessons'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::all();
        $levels = Level::all();
        $sessions = Session::latest('year')->get();
        // return $sessions;
        return view('admin.pages.lessons.create', compact('programs', 'levels', 'sessions'));
    }

    public function createCourse($course)
    {
        $programs = Program::all();
        $levels = Level::all();
        return view('admin.pages.lessons.create', compact('programs', 'levels', 'course'));
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
                'course_id' => 'required|integer',
                'session_id' => 'required|integer',
                'image' => 'required|image',
                'topic' => 'required|max:1000',
                'description' => 'required',
                'visibility' => 'required',
            ],
            [
                'course_id.required' => 'Please choose the course that this lesson belongs to',
                'session_id.required' => 'Please choose the session that this lesson belongs to'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $l = new Lesson();
        $l->topic = $request->topic;
        $slug = Str::limit(Str::slug($request->topic,), 190, '');

        if (Lesson::where('slug', $slug)->first()) {
            $slug = $slug . '-' . Lesson::where('slug', 'like', "%$slug%")->get()->count();
        }

        $l->slug = $slug;
        $l->course_id = $request->course_id;
        $l->description = $request->description;
        $l->session_id = $request->session_id;
        $l->active = intval($request->active);
        $l->visibility = $request->visibility;

        // saving image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = Str::slug(Str::random(10)) . time()
                    . '.' . $file->getClientOriginalExtension();
                $l->image = $file->storeAs('materials/previews', $name);
            }
        }

        $l->save();

        return [
            'status' => 200,
            'parent_id' => $l->id,
            'to' => route('admin.lessons'),
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $lesson = Lesson::where('slug', $slug)->firstOrFail();
        $lessons =  $lesson->materials;
        // return $lessons;
        return view('frontend.portal.lessons.materials', compact('lessons'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $courses = Course::all();
        $levels = Level::all();
        $programs = Program::all();
        $sessions = Session::latest('year')->get();

        $course = $lesson->course;
        $program = $course ? $course->program : null;
        $level = $course ? $course->level : null;

        $items = [
            'course' => $course,
        ];

        $items['program'] = $program;
        $items['level'] = $level;


        $courses = [];
        if ($program && $level) {
            $courses = Course::where('program_id', $program->id)
                ->where('level_id', $level->id)->get();
        }
        $items['courses'] = $courses;

        $items = collect($items);

        return view('admin.pages.lessons.edit', compact(
            'lesson',
            'levels',
            'programs',
            'sessions',
            'items'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'course_id' => 'required|integer',
                'session_id' => 'required|integer',
                'topic' => 'required|max:1000',
                'description' => 'required',
                'visibility' => 'required'
            ],
            [
                'course_id.required' => 'Please choose course',
                'session_id.required' => 'Please choose Session'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $l = $lesson;
        $l->topic = $request->topic;

        $l->course_id = $request->course_id;
        $l->session_id = $request->session_id;
        $l->description = $request->description;
        $l->active = intval($request->active);
        $l->visibility = $request->visibility;

        // saving image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = Str::slug(Str::random(10)) . '-' . time()
                    . '.' . $file->getClientOriginalExtension();
                $l->image = $file->storeAs('lessons/previews', $name);
            }
        }

        $l->save();

        return [
            'status' => 200,
            'parent_id' => $l->id,
            'message' => "$l->topic Updated successfully",
            'to' => route('admin.lessons'),
            'type' => 'success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Lesson::whereIn('id', $ids)->get(['image']);
        // delete images
        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        // delete materials;
        $materials = Material::whereIn('lesson_id', $ids)->get();

        $materials->each(function ($m) {
            if (file_exists(public_path("storage/$m->path")) && $m->path) {
                unlink(public_path("storage/$m->path"));
            }
        });

        $total =  Lesson::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('page', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
