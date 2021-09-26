<?php

namespace App\Http\Controllers;

use App\Models\PublicationCat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = PublicationCat::all();
        return view('admin.pages.publications.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request->validate(['name' => 'required|unique:publication_cats,name']);
        $name = $request->name;
        $slug = Str::slug($name);


        $cat = new  PublicationCat();
        $cat->name = $name;
        $cat->slug = $slug;

        if ($cat->save()) {
            return [
                'message' => "$name - category saved successfully",
                'type' => 'success',
                'status' => 200,
                'timeout' => 10000
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PublicationCat  $publicationCat
     * @return \Illuminate\Http\Response
     */
    public function show(PublicationCat $publicationCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PublicationCat  $publicationCat
     * @return \Illuminate\Http\Response
     */
    public function edit(PublicationCat $publicationCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PublicationCat  $publicationCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PublicationCat $cat)
    {
        // return $request->all();
        $request->validate(['name' => "required|unique:publication_cats,name,$cat->id"]);
        $cat->name = $request->name;

        if ($cat->save()) {
            return [
                'message' => "$cat->name - updated successfully",
                'type' => 'success',
                'status' => 200,
                'timeout' => 10000
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PublicationCat  $publicationCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total =  PublicationCat::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total Publication " . Str::plural('category', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
