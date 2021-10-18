<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.pages.create');
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
                'description' => 'required',
                'title' => 'required|max:150',
                'image' => 'nullable|file|image',
                'slug' => 'required|unique:pages,slug'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $title = $request->title;
        $slug = Str::slug($request->slug);

        $page = new Page();
        $name = null;
        if ($request->name) {
            $name = Str::slug($request->name, '_');
        }
        $page->name = $name;
        $page->title = $title;
        $page->slug = $slug;
        $page->description = $request->description;

        $page->excerpt = $request->excerpt;
        $page->published = intval($request->published);

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $page->image = $file->storeAs('pages', $name);
            }
        }

        $page->save();

        return [
            'message' => "page created successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.pages')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        // return $page;
        return view('frontend.pages.single', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'title' => 'required|max:150',
                'image' => 'nullable|file|image',
                'slug' => "required|unique:pages,slug,$page->id"
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $title = $request->title;
        $slug = Str::slug($request->slug);
        $name = null;
        if ($request->name) {
            $name = Str::slug($request->name, '_');
        }

        $page->title = $title;
        $page->name = $name;
        $page->slug = $slug;
        $page->description = $request->description;

        $page->excerpt = $request->excerpt;
        $page->published = intval($request->published);

        if ($request->remove_image) {
            if (file_exists(public_path("storage/$page->image")) && $page->image) {
                unlink(public_path("storage/$page->image"));
            }
            $page->image = null;
        }

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                if (file_exists(public_path("storage/$page->image")) && $page->image) {
                    unlink(public_path("storage/$page->image"));
                }

                $name = $slug . "-" . time()
                    . '.' . $file->extension();
                $page->image = $file->storeAs('pages', $name);
            }
        }

        $page->save();

        return [
            'message' => "page updated successfully",
            'status' => 200,
            'type' => 'success',
            'to' => route('admin.pages')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Page::whereIn('id', $ids)->whereNull('name')->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Page::whereIn('id', $ids)->whereNull('name')->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('page', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }

    public function static(Request $request)
    {
        $segment = $request->segment(1, 'default');
        $segment = strtok($segment, '.');
        if (view()->exists("frontend.pages.$segment")) {
            return view("frontend.pages.$segment");
        }
        return redirect(route('home'));
    }
}
