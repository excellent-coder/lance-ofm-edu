<?php

namespace App\Http\Controllers;

use App\Models\PostCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = PostCat::all();
        return view('admin.pages.posts.categories', compact('categories'));
    }

    public function children(Request $request)
    {
        // return $request->all();
        if (empty($request->id)) {
            return  [];
        }
        $cat = PostCat::find($request->id);
        if (!$cat) {
            return [];
        }

        return $cat->children;
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
        $name = $request->name;
        $parent = $request->parent_id;
        $slug = Str::slug($name);

        if (PostCat::where('name', $name)
            ->where('parent_id', $parent)
            ->first()
        ) {
            return [
                'message' => "You already saved this category $name",
                'type' => 'error',
                'status' => 200
            ];
        }

        if (PostCat::where('name', $name)->first()) {
            $slug = $slug .= "-" . PostCat::where("name", 'like', "%$name%")->count();
        }

        $cat = new PostCat();
        $cat->name = $name;
        $cat->parent_id = $parent;
        $cat->slug = $slug;
        $cat->active = intval($request->active);

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
     * @param  \App\Models\PostCat  $postCat
     * @return \Illuminate\Http\Response
     */
    public function show(PostCat $postCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostCat  $postCat
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCat $postCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCat  $postCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostCat $cat)
    {
        // return $request->all();
        $name = $request->name;
        $parent = $request->parent_id;

        if (PostCat::where('name', $name)
            ->where('parent_id', $parent)
            ->where('id', '!=', $cat->id)
            ->first()
        ) {
            return [
                'message' => "You already saved this category $name",
                'type' => 'error',
                'status' => 200
            ];
        }


        $cat->name = $name;
        $cat->parent_id = $parent;
        $cat->active = intval($request->active);

        if ($cat->save()) {
            return [
                'message' => "$name - category updated successfully",
                'type' => 'success',
                'status' => 200,
                'timeout' => 10000
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostCat  $postCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);

        $total =  PostCat::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total Post " . Str::plural('category', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
