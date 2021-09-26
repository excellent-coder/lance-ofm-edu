<?php

namespace App\Http\Controllers;

use App\Models\MemberPayment;
use App\Models\Publication;
use App\Models\PublicationCat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pubs = Publication::all();
        return view('admin.pages.publications.index', compact('pubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PublicationCat::all();
        return view('admin.pages.publications.create', compact('categories'));
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
        $request->validate([
            'title' => 'required|max:225',
            'category' => 'required|integer',
            'image' => 'required|image',
            'description' => 'required',
            'docs' => 'required|file|mimes:pdf,docx',
        ]);



        $slug = Str::slug($request->title);
        if (Publication::whereSlug($slug)->first()) {
            $slug = $slug . '-' . Publication::where('slug', 'like', "%$slug%")->count();
        }

        $pub = new Publication();
        $pub->title = $request->title;
        $pub->slug = $slug;
        $pub->cat_id = $request->category;

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $pub->image = $file->storeAs('publications/images', $name);
            }
        }

        // add file for download
        if ($request->hasFile('docs')) {
            $file = $request->file('docs');
            if ($file->isValid()) {
                $name = $slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $pub->docs = $file->storeAs("publications", $name);
            }
        }

        $pub->featured = $request->filled('featured');
        $pub->published = $request->filled('published');
        $pub->price = $request->price;
        $pub->volume = $request->volume;
        $pub->description = $request->description;
        $pub->save();

        return [
            'message' => 'Publication added successfully',
            'type' => 'success',
            'status' => 200,
            'to' => route('admin.pubs')
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        $categories = PublicationCat::all();
        return view('admin.pages.publications.edit', compact('publication', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        // return $request->all();
        $request->validate([
            'title' => 'required|max:225',
            'category' => 'required|integer',
            'image' => 'nullable|image',
            'description' => 'required',
            'docs' => 'nullable|file|mimes:pdf,docx',
        ]);
        $pub = $publication;
        $pub->title = $request->title;
        $pub->cat_id = $request->category;

        // add featured image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {

                $name = $pub->slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $pub->image = $file->storeAs('publications/images', $name);
            }
        }

        // add file for download
        if ($request->hasFile('docs')) {
            $file = $request->file('docs');
            if ($file->isValid()) {
                $name = $pub->slug . "-" . time()
                    . '.' . $file->getClientOriginalExtension();
                $pub->docs = $file->storeAs("publications", $name);
            }
        }

        $pub->featured = $request->filled('featured');
        $pub->published = $request->filled('published');
        $pub->price = $request->price;
        $pub->volume = $request->volume;
        $pub->description = $request->description;
        $pub->save();

        return [
            'message' => 'Publication updated successfully',
            'type' => 'success',
            'status' => 200,
            'to' => route('admin.pubs')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        $ids = explode(',', $ids);
        $images = Publication::whereIn('id', $ids)->get(['image']);

        $images->each(function ($img) {
            if (file_exists(public_path("storage/$img->image")) && $img->image) {
                unlink(public_path("storage/$img->image"));
            }
        });

        $total =  Publication::whereIn('id', $ids)->delete();
        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('publication', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }


    public function download(Publication $pub)
    {
        if ($pub->price) {
            return redirect('404');
        }
        $name =  "ISAM-PUBLICATION-" . time() . '.' . pathinfo($pub->docs, PATHINFO_EXTENSION);
        return response()->download(public_path("storage/$pub->docs"), $name);
    }

    public function paidDownload(Publication $pub, MemberPayment $payment)
    {
        if ($pub->price) {
            return redirect('404');
        }
        $name =  "ISAM-PUBLICATION-" . time() . '.' . pathinfo($pub->docs, PATHINFO_EXTENSION);
        return response()->download(public_path("storage/$pub->docs"), $name);
    }
}
