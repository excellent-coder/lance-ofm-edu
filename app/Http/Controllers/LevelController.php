<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $last = Level::latest('level')->first();
        $lastLevel = 0;
        if ($last) {
            $lastLevel = $last->level;
        }
        $levels = Level::orderBy('level', 'ASC')->get();
        return view('admin.pages.levels.index', compact('levels', 'lastLevel'));
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
                'order' => 'required|min:1|unique:levels,level',
                'name' => 'required|unique:levels,name',
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $level = new Level();
        $level->name = $request->name;
        $level->slug = Str::slug($request->name);
        $level->level = $request->order;

        $level->save();

        return [
            'message' => "level created successfully",
            'status' => 200,
            'type' => 'success',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'order' => "required|min:1|unique:levels,level,$level->id",
                'name' => "required|unique:levels,name,$level->id",
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $level->name = $request->name;
        $level->slug = Str::slug($request->name);
        $level->level = $request->order;

        $level->save();

        return [
            'message' => "level Updated successfully",
            'status' => 200,
            'type' => 'success',
            'desc' => 'Reload page to see changes'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        //
    }
}
