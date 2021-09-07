<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\ScsProgram;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScsProgramController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScsProgram  $scsProgram
     * @return \Illuminate\Http\Response
     */
    public function show(ScsProgram $app)
    {
        $sessions = Session::all();
        $levels = Level::all();
        // return $app;
        return view('admin.pages.scs.program', compact('app', 'sessions', 'levels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScsProgram  $scsProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(ScsProgram $scsProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScsProgram  $scsProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScsProgram $app)
    {
        if (!$request->filled('approve') && !$app->approved_at) {
            return [
                'message' => 'No update has been made',
                'desc' => 'To update plase approve the request',
                'type' => 'info',
                'status' => 200
            ];
        }
        $valid = Validator::make(
            $request->all(),
            [
                'session' => 'required',
                'level' => 'required',
                'start_at' => 'required',
                'end_at' => 'required',
            ]
        );
        if ($valid->fails()) {
            return [
                'message' => 'Some Fields Missing',
                'errors' => $valid->errors()->all()
            ];
        }

        $app->approved_at = date('Y-m-d H:i:s');
        $app->level_id = $request->level;
        $app->session_id = $request->session;
        $app->start_at = $request->start_at;
        $app->end_at = $request->end_at;

        $app->save();

        return [
            'message' => 'You have successfully approved this request',
            'status' => 200,
            'type' => 'success'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScsProgram  $scsProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScsProgram $scsProgram)
    {
        //
    }
}
