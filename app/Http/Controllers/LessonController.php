<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $subjects = Subject::all(['id', 'name']);
        return view('admin.pages.lessons.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $valid = Validator::make(
            $request->all(),
            [
                'subject_id' => 'required|integer',
                'photo' => 'required|image',
                'topic' => 'required|max:1000',
                'description' => 'required'
            ],
            [
                'subject_id.required' => 'Please choose subject'
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
        $l->subject_id = $request->subject_id;
        $l->description = $request->description;
        $l->active = intval($request->active);

        // saving photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file->isValid()) {

                $name = Str::slug(Str::random(10)) . time()
                    . '.' . $file->extension();
                $l->photo = $file->storeAs('materials/previews', $name);
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
        $subjects = Subject::all(['id', 'name']);
        return view('admin.pages.lessons.edit', compact('lesson', 'subjects'));
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
        $valid = Validator::make(
            $request->all(),
            [
                'subject_id' => 'required|integer',
                'topic' => 'required|max:1000',
                'description' => 'required'
            ],
            [
                'subject_id.required' => 'Please choose subject'
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

        $l->subject_id = $request->subject_id;
        $l->description = $request->description;
        $l->active = intval($request->active);

        // saving photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file->isValid()) {

                $name = Str::slug(Str::random(10)) . time()
                    . '.' . $file->extension();
                $l->photo = $file->storeAs('materials/previews', $name);
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
    public function destroy(Lesson $lesson)
    {
        //
    }
}
