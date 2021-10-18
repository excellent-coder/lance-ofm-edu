<?php

namespace App\Http\Controllers;

use App\Models\ExamCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centers = ExamCenter::all();
        return view('admin.pages.exam.center', compact('centers'));
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
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'capacity' => 'required',
            'image' => 'nullable|image'
        ]);

        $s = new ExamCenter();
        $s->name = $request->name;
        $s->address = $request->address;
        $s->capacity = $request->capacity;
        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $name = Str::slug($request->name) . "-" . time() . '.' . $file->getClientOriginalExtension();
                $s->image = $file->storeAs('licences', $name);
            }
        }

        $s->save();
        return [
            'status' => 200,
            'message' => 'New Exam Center saved',
            'desc' => 'refresh page to see changes',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamCenter  $examCenter
     * @return \Illuminate\Http\Response
     */
    public function show(ExamCenter $examCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamCenter  $examCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamCenter $examCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamCenter  $examCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamCenter $center)
    {
        $request->validate([
            'name' => "required|unique:exam_centers,name,$center->id",
            'address' => 'required',
            'capacity' => 'required',
            'image' => 'nullable|image'
        ]);

        $center->name = $request->name;
        $center->address = $request->address;
        $center->capacity = $request->capacity;
        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $name = Str::slug($request->name) . "-" . time() . '.' . $file->getClientOriginalExtension();
                $center->image = $file->storeAs('licences', $name);
            }
        }

        $center->save();
        return [
            'status' => 200,
            'message' => 'Exam Center updated'
        ];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamCenter  $examCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamCenter $examCenter)
    {
        //
    }
}
