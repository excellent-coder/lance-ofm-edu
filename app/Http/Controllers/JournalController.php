<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::all();
        return view('admin.pages.journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.journals.create');
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
        $valid = Validator::make(
            $request->all(),
            [
                'pdf' => 'required|file|mimes:pdf',
                'title' => 'required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $pdf = new Journal();
        $pdf->title = $request->title;
        $pdf->slug = $request->slug;
        $slug = Str::slug(Str::limit($request->title, 150, ''));

        if (Journal::where('slug', $slug)->first()) {
            $slug .= '-' . Journal::where('slug', 'like', "%$slug%")->count();
        }

        $pdf->active = $request->filled('active');
        $pdf->slug = $slug;

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            if ($file->isValid()) {

                $name = $slug . '.' . $file->getClientOriginalExtension();
                $pdf->pdf = $file->storeAs('journals', $name);
            }
        }
        $pdf->save();

        return [
            'message' => 'Journal Added successfully',
            'status' => 200,
            'to' => route('admin.journals'),
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
