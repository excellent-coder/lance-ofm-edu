<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationCat;
use App\Models\User;
use App\Models\UserTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notification::all();
        return view('admin.pages.notifications.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = NotificationCat::all();
        return view('admin.pages.notifications.create', compact('categories'));
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
                'subject' => 'required',
                'receivers' => 'required',
                'body' => 'required'
            ]
        );

        if ($valid->fails()) {
            return [
                'message' => 'You have some errors',
                'errors' => $valid->errors()->all()
            ];
        }

        $n = new Notification();

        $subject = $request->subject;

        $slug = Str::limit(Str::slug($subject), 180, '');

        if (Notification::where('slug', $slug)->first()) {
            $slug .= '-' . Notification::where('slug', 'like', "%$slug%")->count();
        }

        $n->subject = $subject;
        $n->slug = $slug;
        $n->body = $request->body;
        $n->category_id = $request->receivers;
        $n->published = $request->filled('publshed');
        $n->save();

        return [
            'message' => 'Notifiction Added successfully',
            'status' => 200,
            'to' => route('admin.notifications'),
            'type' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $notice = Notification::where('slug', $slug)->firstOrFail();
        $model = UserTable::where('model', 'User')->first();
        return view('admin.pages.notifications.show', compact('notice', 'model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
