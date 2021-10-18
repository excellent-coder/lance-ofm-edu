<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\ImagePart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();
        $parts = ImagePart::all();
        return view('admin.pages.images.index', compact('images', 'parts'));
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

    public function storePart(Request $request)
    {
        $p = new ImagePart();
        if ($request->id) {
            $p = ImagePart::find($request->id);
        }
        $p->part = $request->part;
        $p->save();
        return [
            'message' => "$p->part saved",
            'status' => 200,
            'type' => 'success'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->part) {
            $request->session()->put('images.store', $request->all());
            return [
                'status' => 200,
                'parent_id' => 1,
                'to' => route('admin.images'),
                'type' => 'success'
            ];
        }

        if ($request->parent_id) {
            $img = new Image();

            $img->part_id = session('images.store')['part'];
            $part = ImagePart::find($img->part_id);
            $img->active = isset(session('images.store')['active']);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if ($file->isValid()) {

                    $name =  Str::random(5) . "-" . time()
                        . '.' . $file->extension();
                    $img->src = $file->storeAs("images/$part->part", $name);

                    $img->save();
                    return [
                        'status' => 200,
                        'type' => 'success',
                        'message' => "upload successful"
                    ];
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        // return $image;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $request->validate(['part' => 'required']);
        $img = $image;

        $img->part_id = $request->part;
        $img->active = $request->filled('active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                if (file_exists(public_path("storage/$img->src")) && $img->src) {
                    unlink(public_path("storage/$img->src"));
                }
                $part = ImagePart::find($img->part_id);
                $name =  Str::random(5) . "-" . time() . '.' . $file->getClientOriginalExtension();
                $img->src = $file->storeAs("images/$part->part", $name);
            }
        }
        $img->save();
        return [
            'status' => 200,
            'type' => 'success',
            'message' => "update successful"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Image::whereIn('id', $ids)->get(['src']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->src")) && $img->src) {
                unlink(public_path("storage/$img->src"));
            }
        });

        $total =  Image::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('image', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
