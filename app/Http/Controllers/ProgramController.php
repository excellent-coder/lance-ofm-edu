<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::all();
        return view('admin.pages.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::orderBy('level', 'ASC')->get();
        return view('admin.pages.programs.create', compact('levels'));
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
                'excerpt' => 'required',
                'main_student_app_fee' => 'required_if:is_program,1',
                'scs_app_fee' => 'required_if:is_program,1',
                'visibility' => 'required_if:is_program,1',
                'title' => 'required|max:150|unique:programs,title',
                'abbr' => 'required|max:100|unique:programs,abbr',
                'image' => 'nullable|file|image'
            ],
            [
                'title.unique' => 'This program is already taken',
                'abbr.unique' => 'A program with this abbreviation already exists',
                'excerpt.required' => "Short Description is required",
                'visibility' => 'Choose the type of students that can apply for this program'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $slug = Str::slug($request->abbr);

        $program = new Program;

        $program->slug = $slug;
        $program->title = $request->title;
        $program->abbr = $request->abbr;
        $program->description = $request->description;

        $program->excerpt = $request->excerpt;
        $program->visibility = $request->visibility;
        $program->active = $request->filled('active');
        $program->is_program = $request->filled('is_program');

        $program->main_student_app_fee = $request->main_student_app_fee;
        $program->scs_app_fee = $request->scs_app_fee;

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $name = $slug . '.' . $file->getClientOriginalExtension();
                $program->image = $file->storeAs('programs', $name);
            }
        }

        $program->save();

        return [
            'message' => "new program addeded successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.programs')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $slug = preg_replace('/^(scs|scourses?|short-courses?)$/i', 'scs', $slug);
        $program = Program::where('slug', $slug)->firstOrFail();
        // return $course;
        // $slug =  preg_replace('/^(scs|scourses?|short-course.*)$/i', 'scourse', $slug);

        // return $slug;
        if (view()->exists("frontend.programs.static.$slug")) {
            return view("frontend.programs.static.$slug", compact('program'));
        }
        return view('frontend.programs.single', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        $levels = Level::orderBy('level', 'ASC')->get();
        return view('admin.pages.programs.edit', compact('program', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        // return $request->all();

        $valid = Validator::make(
            $request->all(),
            [
                'excerpt' => 'required',
                'visibility' => 'required_if:is_program,1',
                'title' => "required|max:150|unique:programs,title,$program->id",
                'abbr' => "required|max:100|unique:programs,abbr,$program->id",
                'image' => 'nullable|file|image'
            ],
            [
                'title.unique' => 'This program is already taken',
                'abbr.unique' => 'A program with this abbreviation already exists',
                'excerpt.required' => "Short Description is required",
                'visibility' => 'Choose the type of students that can apply for this program'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $slug = Str::slug($request->abbr);

        $program->title = $request->title;
        $program->abbr = $request->abbr;

        $program->description = $request->description;

        $program->excerpt = $request->excerpt;
        $program->visibility = $request->visibility;
        $program->active = $request->filled('active');
        $program->is_program = $request->filled('is_program');

        $program->main_student_app_fee = $request->main_student_app_fee;
        $program->scs_app_fee = $request->scs_app_fee;

        if ($request->remove_image) {
            if (file_exists(public_path("storage/$program->image")) && $program->image) {
                unlink(public_path("storage/$program->image"));
            }
            $program->image = null;
        }

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                if (file_exists(public_path("storage/$program->image")) && $program->image) {
                    unlink(public_path("storage/$program->image"));
                }

                $name = $slug . '.' . $file->getClientOriginalExtension();
                $program->image = $file->storeAs('programs', $name);
            }
        }

        $program->save();

        return [
            'message' => "$program->abbr updated successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.programs')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Program::whereIn('id', $ids)->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Program::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('program', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
