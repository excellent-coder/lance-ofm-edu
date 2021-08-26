<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationReply;
use App\Models\UserTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NotificationReplyController extends Controller
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
    public function store(Request $request, Notification $notice, UserTable $model)
    {
        // return $request->all();
        $valid = Validator::make(
            $request->all(),
            [
                'body' => 'required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'Required Field Missing',
                'type' => 'error',
                'status' => 200
            ];
        }

        $r = new NotificationReply();
        $r->notification_id = $notice->id;
        $r->user_table_id = $model->id;
        $r->body = $request->body;
        $sender = auth($request->gd)->id();

        if (!$sender) {
            return response(['message' => 'Unauthorized'], 401);
        }

        if (!$request->gd) {
            $r->approved_at = date('Y-m-d H:i:s');
        }
        $r->sender_id = $sender;

        $r->save();
        return [
            'message' => 'Reply Sent successfully',
            'status' => 200,
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationReply  $notificationReply
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationReply $notificationReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationReply  $notificationReply
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationReply $notificationReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificationReply  $notificationReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationReply $notificationReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationReply  $notificationReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationReply $notificationReply)
    {
        //
    }
}
