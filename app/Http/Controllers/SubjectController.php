<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Subject;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\UserCategorySubject;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        $cats = UserCategory::where('parent_id', null)->get();
        $sessions = Session::all();
        $session = Session::where('active', 1)->first();
        $session_id = '';
        if ($session) {
            $session_id = $session->id;
        }


        $cardLinks = [];

        // return $subjects->load('categories');
        return view(
            'admin.pages.subjects.index',
            compact(
                'subjects',
                'cardLinks',
                'cats',
                'sessions',
                'session_id'
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
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'code' => 'required|max:192',
                'user_category_id' => 'required',

            ],
            []
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $userCats = $request->user_category_id;

        // return $request->input('user_category_id');
        $s = new Subject();

        $slug = Str::slug($request->code);

        if (Subject::where('slug', $slug)->first()) {
            $slug = $slug . '-' . Subject::where('slug', $slug)->get()->count();
        }

        $s->name = $request->name;
        $s->code = $request->code;
        $s->slug = $slug;
        $s->save();
        foreach ($userCats as $uc) {
            UserCategorySubject::create([
                'user_category_id' => $uc,
                'subject_id' => $s->id
            ]);
        }
        return [
            'status' => 200,
            'message' => 'New subject saved',
            'desc' => 'refresh page to see changes',
        ];
        // save user_category_subject
        // $us = new UserCategorySubject;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $subject = Subject::where('slug', $slug)->firstOrFail();
        $lessons = $subject->lessons;
        // $lessons = $lessons->load('materials');
        // return $lessons;
        return view('frontend.portal.lessons.show', compact('lessons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'code' => 'required|max:192',
                'user_category_id' => 'required',

            ],
            []
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $userCats = $request->user_category_id;

        // return $request->input('user_category_id');
        $s = $subject;

        $slug = Str::slug($request->code);

        if (Subject::where('slug', $slug)->where('id', '!=', $s->id)
            ->first()
        ) {
            $slug = $slug . '-' . Subject::where('slug', $slug)->get()->count();
        }

        $s->name = $request->name;
        $s->code = $request->code;
        $s->slug = $slug;
        $s->save();
        // drop all relations in pivot table;
        UserCategorySubject::where('subject_id', $s->id)->delete();

        foreach ($userCats as $uc) {
            UserCategorySubject::create([
                'user_category_id' => $uc,
                'subject_id' => $s->id
            ]);
        }
        return [
            'status' => 200,
            'message' => "$s->name  updated successfully",
            'desc' => 'refresh page to see changes',
        ];
        // save user_category_subject
        // $us = new UserCategorySubject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total =  Subject::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('subject', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
