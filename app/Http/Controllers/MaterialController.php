<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // return $request->all();
        if (!$request->parent_id) {
            return [
                'message' => 'Unable to upload this file',
                'type' => 'error',
            ];
        }
        $m = new Material();
        $m->lesson_id = $request->parent_id;
        $m->allow_download = $request->allow_download;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $m->name = $file->getClientOriginalName();
                $m->type = explode('/', $file->getMimeType())[0];

                $path = Str::slug(Str::random(20)) . '-' . time()
                    . '.' . $file->getClientOriginalExtension();
                $m->path = $file->storeAs('lesson/materials', $path);

                $m->save();
                return [
                    'status' => 200,
                    'type' => 'success',
                    'message' => "$m->name Uploaded successfully"
                ];
            }
        }

        return [
            'status' => 200,
            'type' => 'error',
            'message' => "1 Upload failed"
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    public function activate(Request $request, Material $material)
    {
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
}
