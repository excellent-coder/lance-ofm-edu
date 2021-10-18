<?php

namespace App\Http\Controllers;

use App\Helpers\Env;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::all();
        $cardLinks = [
            [
                'type' => 'modal',
                'title' => 'New Session',
                'icon' => 'plus', 'route' => 'general',
                'show' => false
            ]
        ];
        return view('admin.pages.sessions.index', compact('sessions', 'cardLinks'));
    }

    /**
     * Make a session active and disable all other sessions
     *
     * @return \Illuminate\Http\Response
     */
    public function activate(Session $session, $admin = '')
    {


        if ($admin) {
            return [
                'status' => 200,
                'message' => 'admin session updated successfully'
            ];
        }


        $status = intval(!$session->active);
        if ($status == 1) {
            DB::update("update sessions set active = '0'");
            $session->active = 1;
            $session->save();
            return [
                'status' => 200,
                'message' => "$session->name now set to active session",
                'add_class' => 'fa-check',
                'remove_class' => 'fa-times',
                'timeout' => 10000,
                'toggle' => true
            ];
        } else {
            return [
                'status' => 200,
                'type' => 'info',
                'message' => 'Unable to deactivate this session',
                'desc' => 'You must have one active session, please try activating the session
                that should be active first'
            ];
        }
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
                'name' => 'required|max:191|unique:sessions,name',
                'year' => 'required|regex:/\d{4}/|unique:sessions,year',
                'start_at' => 'required'


            ],
            []
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $s = new Session();
        $s->name = $request->name;
        $s->year = $request->year;
        $s->start_at = $request->start_at;
        $s->end_at = $request->end_at;
        $s->save();
        return [
            'status' => 200,
            'message' => 'New session saved',
            'desc' => 'refresh page to see changes',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $session)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'name' => "required|max:191|unique:sessions,name,$session->id",
                'year' => "required|regex:/\d{4}/|unique:sessions,year,$session->id",
                'start_at' => 'required'


            ],
            []
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }
        $s = $session;
        $s->name = $request->name;
        $s->year = $request->year;
        $s->start_at = $request->start_at;
        $s->end_at = $request->end_at;
        $s->save();
        return [
            'status' => 200,
            'message' => "$session->name session updated successfully",
            'desc' => 'refresh page to see changes',
            'hide_modal' => '#general-modal'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return [
            'message' => 'Session deleting is not allowed',
            'type' => 'warning',
            'status' => 200
        ];
        $ids = trim($request->ids, ',');

        if (empty($ids)) {
            return ['message' => 'nothing to delete'];
        }

        // $ids = explode(',', $ids);

        $total = Session::whereIn('id', $ids)->whereActive('0')->delete();

        if (!$total) {
            return [
                'type' => 'info',
                'message' => 'Unable to excute the delete command',
                'desc' => 'Reload this page and try again'
            ];
        }

        $desc = $total > 1 ? 'Reload this page to see changes' : '';

        return [
            'message' => "$total " . Str::plural('session', $total) . " Deleted successfuly",
            'status' => 200,
            'desc' => $desc
        ];
    }
}
