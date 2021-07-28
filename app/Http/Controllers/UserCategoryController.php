<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = UserCategory::where('parent_id', null)->get();
        $cardLinks = [
            [
                'type' => 'modal',
                'title' => 'New Category',
                'icon' => 'plus', 'route' => 'general'
            ]
        ];
        return view('admin.pages.user-categories.index', compact('categories', 'cardLinks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $cat = UserCategory::where('slug', $slug)->firstOrFail();
        $categories = $cat->children;
        return view('frontend.portal.applications.create', compact('categories', 'cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat = new UserCategory();

        $exist = UserCategory::where('name', $request->name)
            ->where('parent_id', $request->parent_id)->first();
        if ($exist) {
            return [
                'message' => 'You already have this category saved',
                'type' => 'error'
            ];
        }

        $cat->name = $request->name;
        $cat->visibility = $request->visibility;
        $cat->slug = Str::limit(Str::slug($request->name), 190, '');

        if (!empty($request->parent_id)) {
            if (UserCategory::where('name', $request->name)->first()) {
                $cat->slug = $cat->slug . '-' . $request->parent_id;
            }
        }

        $cat->parent_id = $request->parent_id;

        $cat->save();

        $children = $request->children;

        foreach ($children as $ch) {
            $super = UserCategory::find($ch);
            if (!$super || $ch == $cat->id) {
                continue;
            }
            $super->super_parent = $cat->id;
            $super->save();
        }

        return [
            'item' => $cat,
            'type' => 'success',
            'status' => 200,
            'timeout' => 10000,
            'message' => 'category added successfully'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function show(UserCategory $userCategory)
    {
        return view('frontend.portal.applications.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(UserCategory $userCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserCategory $category)
    {

        $category->name = $request->name;
        if ($category->id == $request->parent_id) {
            return [
                'message' => "This category $request->name cannot be parent of itself",
                'type' => 'error',
                'status' => 200
            ];
        }
        $category->parent_id = $request->parent_id;
        $category->visibility = $request->visibility;
        $category->slug = Str::limit(Str::slug($request->name), 190, '');
        $category->save();

        $children = $request->children;

        foreach ($children as $ch) {
            $super = UserCategory::find($ch);
            if (!$super || $ch == $category->id) {
                continue;
            }
            $super->super_parent = $category->id;
            $super->save();
        }

        return [
            'item' => $category,
            'type' => 'success',
            'status' => 200,
            'message' => "$category->name updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $ids = trim($request->ids, ',');
        $ids = explode(',', $ids);

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $children =  UserCategory::whereIn('parent_id', $ids);
        $total_children = $children->get()->count();
        // $children->delete();

        UserCategory::whereIn('id', $ids)->delete();
        $total = count($ids);
        $message = $total_children ? "$total + $total_children" : $total;
        return [
            'message' => "$message " . Str::plural('category', $total + $total_children) . " Deleted successfuly",
            'status' => 200
        ];
    }
}
